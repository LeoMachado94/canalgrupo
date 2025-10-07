FROM node:16-alpine

WORKDIR /src

CMD npm install && npx mix watch --hot
