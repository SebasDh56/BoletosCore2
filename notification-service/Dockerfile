FROM node:16
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY notification-service.js .
CMD ["node", "notification-service.js"]