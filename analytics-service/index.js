require('dotenv').config();
const amqp = require('amqplib');
const mongoose = require('mongoose');
const express = require('express');

(async () => {
  await mongoose.connect(process.env.MONGO_URI);
  const Sale = mongoose.model('Sale', new mongoose.Schema({
    email: String,
    userName: String,
    cooperativa_nombre: String,
    cantidad_boletos: Number,
    comision: Number,
    createdAt: { type: Date, default: Date.now }
  }));

  const conn = await amqp.connect(process.env.AMQP_URL || 'amqp://localhost');
  const ch = await conn.createChannel();
  const q = 'ticket_purchase';
  await ch.assertQueue(q, { durable: true });
  console.log('📊 Analytics service escuchando');

  ch.consume(q, async msg => {
    if (!msg) return;
    const data = JSON.parse(msg.content.toString());
    await Sale.create(data);
    console.log('💾 Guardado en Mongo:', data.email);
    ch.ack(msg);
  });

  // Endpoint GET /analytics/ventas
  const app = express();
  app.get('/analytics/ventas', async (_req, res) => {
    const total = await Sale.countDocuments();
    const ingresos = await Sale.aggregate([{ $group: { _id: null, total: { $sum: '$comision' } } }]);
    const top = await Sale.aggregate([
      { $group: { _id: '$cooperativa_nombre', ventas: { $sum: 1 } } },
      { $sort: { ventas: -1 } },
      { $limit: 5 }
    ]);
    res.json({ total, ingresos: ingresos[0]?.total || 0, top });
  });
    const cors = require('cors');
    app.use(cors());
  app.listen(4000, () => console.log('🔍 API Analytics http://localhost:4000/analytics/ventas'));
})();