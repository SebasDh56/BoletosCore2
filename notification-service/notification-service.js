const amqp = require('amqplib');
const nodemailer = require('nodemailer');

async function startNotificationService() {
  try {
    const connection = await amqp.connect('amqp://host.docker.internal:5672');
    const channel = await connection.createChannel();
    const queue = 'ticket_purchase';

    await channel.assertQueue(queue, { durable: true });
    console.log('Notification Service: Waiting for messages in %s', queue);

    const transporter = nodemailer.createTransport({
      host: 'smtp.ethereal.email',
      port: 587,
      auth: {
        user: 'ayla.monahan79@ethereal.email',
        pass: 'nUfvBzt5HedP7Bk3cG',
      },
    });

    channel.consume(queue, async (msg) => {
      if (msg !== null) {
        try {
          const sale = JSON.parse(msg.content.toString());
          console.log('Received sale:', sale);

          const mailOptions = {
            from: 'boletoscore@gmail.com',
            to: sale.email,
            subject: 'Confirmación de Compra',
            text: `Estimado/a ${sale.userName},\n\nTu compra de ${sale.cantidad_boletos} boleto(s) para ${sale.cooperativa_nombre} fue confirmada.\nTotal: $${sale.total}\n\n¡Gracias!`,
          };

          await transporter.sendMail(mailOptions);
          console.log('Correo enviado a', sale.email);
          channel.ack(msg);
        } catch (e) {
          console.error('Error enviando correo:', e);
          channel.ack(msg);
        }
      }
    });
  } catch (e) {
    console.error('Error conectando a RabbitMQ:', e);
    setTimeout(startNotificationService, 5000);
  }
}

startNotificationService();