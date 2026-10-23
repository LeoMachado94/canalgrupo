<?php

namespace App\Http\Controllers;

use App\Models\Clipping;
use App\Models\Middle;
use App\Repositories\ClippingRepository;
use App\Repositories\MiddleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Auth;
use function foo\func;

class HomeController extends Controller
{
    protected $middleRepository;
    protected $clippingRepository;
    protected $months = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MiddleRepository $middleRepository, ClippingRepository $clippingRepository)
    {
        $this->middleRepository = $middleRepository;
        $this->clippingRepository = $clippingRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        dd(Auth::getDefaultDriver());
        $dateEnd = Carbon::today();
        $month = (int) $dateEnd->format('m');
        $month = $month > 1 ? ($month - 1) : $month;
        $year = $month > 1 ? (int) $dateEnd->format('Y') : ((int)$dateEnd->format('Y') - 1);
        $dateStart = Carbon::createFromDate($year, $month, 01);
        $dateStartPreviousMonth = Carbon::createFromDate($year, $month, 01)->addDays(-30);
        $dateStartPreviousMonth = Carbon::createFromDate(
            $dateStartPreviousMonth->format('Y'), $dateStartPreviousMonth->format('m'), 1
        );

        if (Auth::guard('client')->user()) {
            $middles = Middle::withCount([
                'clippings as count_clippings' => function ($query) use ($dateStart, $dateEnd) {
                    $query->where('client_id', '>=', Auth::guard('client')->user()->id);
                    $query->where('date', '>=', $dateStart);
                    $query->where('date', '<=', $dateEnd);
                },
                'clippings as count_clippings_previous' => function ($query) use ($dateStart, $dateStartPreviousMonth) {
                    $query->where('client_id', '>=', Auth::guard('client')->user()->id);
                    $query->where('date', '>=', $dateStartPreviousMonth);
                    $query->where('date', '<', $dateStart);
                }
            ])->get()->toArray();
        } else {
            $middles = Middle::withCount([
                'clippings as count_clippings' => function ($query) use ($dateStart, $dateEnd) {
                    $query->where('date', '>=', $dateStart);
                    $query->where('date', '<=', $dateEnd);
                },
                'clippings as count_clippings_previous' => function ($query) use ($dateStart, $dateStartPreviousMonth) {
                    $query->where('date', '>=', $dateStartPreviousMonth);
                    $query->where('date', '<', $dateStart);
                }
            ])->get()->toArray();
        }

        // Middles
        $middles = collect($middles);
        $middles->transform(function ($item, $key) {
            $item = collect($item);
            if ($item->get('count_clippings') > $item->get('count_clippings_previous')) {
                $diff = ($item->get('count_clippings') - $item->get('count_clippings_previous'));
                if ($item->get('count_clippings_previous') === 0) {
                    $diff_percent = $diff*100;
                } else {
                    $diff_percent = ($diff/$item->get('count_clippings_previous'))*100;
                }
                $direction = 'asc';
            }

            if ($item->get('count_clippings') < $item->get('count_clippings_previous')) {
                $diff = ($item->get('count_clippings_previous') - $item->get('count_clippings'));
                if ($item->get('count_clippings') === 0) {
                    $diff_percent = $diff*100;
                } else {
                    $diff_percent = ($diff/$item->get('count_clippings_previous'))*100;
                }
                $direction = 'desc';
            }

            if ($item->get('count_clippings') === $item->get('count_clippings_previous')) {
                $diff = 0;
                $diff_percent = 0;
                $direction = 'not';
            }

            $item->put('variation', $diff);
            $item->put('percentage', $diff_percent);
            $item->put('direction', $direction);

            return $item;
        });

        // Clippings
        $monthStart = (int) Carbon::today()->subMonths(6)->format('m');
        $yearStart = (int) Carbon::today()->subMonths(6)->format('Y');
//        $clippings = Clipping::withCount('MONTH(date) = ? AND YEAR(date) = ?', [1, 2020])->get();

        $clippings_per_month = collect();
        for ($i=0; $i < 6; $i++) {
            $month = ($monthStart+$i) > 12 ? ($monthStart+$i)-12 : ($monthStart+$i);
            $year = ($monthStart+$i) > 12 ? $yearStart+1 : $yearStart;

            $clippings_per_month->push([
                'month' => $month,
                'year' => $year,
                'monthName' => $this->months[$month]
            ]);
        }

        $months = collect();
        $years = collect();
        $clippings_per_month->each(function($item) use ($months, $years) {
            if (!$months->contains($item['month'])) $months->push($item['month']);
            if (!$years->contains($item['year'])) $years->push($item['year']);
	});

        if (Auth::guard('client')->user()) {
            $clippings_per_month->transform(function($item) {
                $clippings = Clipping::whereRaw(
                    'MONTH(date) = ? AND YEAR(date) = ? AND client_id = ?', [
                    $item['month'],
                    $item['year'],
                    Auth::guard('client')->user()->id
                ])->get();

                $item['total'] = $clippings->count();
                return $item;
            });
        } else {
            $clippings_per_month->transform(function($item) {
                $clippings = Clipping::whereRaw(
                    'MONTH(date) = ? AND YEAR(date) = ?', [
                    $item['month'],
                    $item['year']
                ])->get();

                $item['total'] = $clippings->count();
                return $item;
            });
        }

        $maxTickClippings = $clippings_per_month->sortByDesc('total')->pluck('total')[0];
	$maxTickClippings = $maxTickClippings >= 10 ?: 10;


        // Clippints By Classification
	$bind = $months->merge($years);
	// Verificar se só tiver um ano (ex.: 2020), então, adicionar outra vez 2020, caso contrário será 2 anos 2020, 2019 por ex. para que possa pegar clipping dos ultimos 6 meses caso esteja em abril/20 (necessitará pegar de nov, dez 19 nesse caso)
        if (Auth::guard('client')->user()) {
            $bind = $bind->toArray();
            array_push($bind, Auth::guard('client')->user()->id);
            // PHP 7.4 ignored bindings beyond the placeholders; PHP 8 rejects them, so keep only the ones PHP 7.4 used.
            $classification = Clipping::whereRaw('MONTH(date) IN (?,?,?,?,?,?) AND YEAR(date) IN (?) AND client_id = ?', array_slice($bind, 0, 8))
                ->orderBy('date', 'asc')->get();
	} else {
            $classification = Clipping::whereRaw('MONTH(date) IN (?,?,?,?,?,?) AND YEAR(date) IN (?)', array_slice($bind->toArray(), 0, 7))
                ->orderBy('date', 'asc')->get();
	}
        $classification_clippings = $classification->count();
        $positive_clippings = collect();
        $negative_clippings = collect();
        $neuter_clippings = collect();

        $classification->each(function($item) use ($positive_clippings, $negative_clippings, $neuter_clippings) {
            if ($item->classification_id === 1) $positive_clippings->push($item);
            if ($item->classification_id === 3) $negative_clippings->push($item);
            if ($item->classification_id === 4) $neuter_clippings->push($item);
        });

        $percentage['positive'] = $positive_clippings->count() > 0 ? ($positive_clippings->count()/$classification_clippings)*100 : 0;
        $percentage['negative'] = $negative_clippings->count() > 0 ? ($negative_clippings->count()/$classification_clippings)*100 : 0;
        $percentage['neuter'] = $neuter_clippings->count() ? ($neuter_clippings->count()/$classification_clippings)*100 : 0;

        return view('home', compact(
            'middles', 'clippings_per_month', 'maxTickClippings', 'percentage'
        ));
    }
}
