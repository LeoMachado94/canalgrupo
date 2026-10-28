FROM node:22-alpine

WORKDIR /src

RUN npm install -g bun

CMD bun install && bun run dev --host
