// index.js
const amqp = require('amqplib');
const nodemailer = require('nodemailer');

(async () => {
  const conn = await amqp.connect('amqp://host.docker.internal');
  const ch   = await conn.createChannel();
  const q    = 'ticket_purchase';
  await ch.assertQueue(q, { durable: true });
  console.log('✅ Notification service escuchando en', q);

  const transporter = nodemailer.createTransport({
  host: 'smtp.ethereal.email',
  port: 587,
  secure: false,
  tls: { rejectUnauthorized: false },   // <-- esta línea es la clave
  auth: {
    user: 'marjolaine44@ethereal.email',
    pass: 'ev2B51WQQkAqpMQqkF'
  }
});

  ch.consume(q, async msg => {
    if (!msg) return;
    const sale = JSON.parse(msg.content.toString());
    console.log('📨 Recibido:', sale);

    await transporter.sendMail({
      from: 'boletoscore@gmail.com',
      to: sale.email,
      subject: 'Confirmación de compra',
      text: `Hola ${sale.userName}, tu compra de ${sale.cantidad_boletos} boleto(s) para ${sale.cooperativa_nombre} está confirmada.`
    });
    console.log('✉️  Correo enviado (fake) a', sale.email);
    ch.ack(msg);
  });
})();