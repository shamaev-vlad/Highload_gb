<?php

echo phpinfo();

// соединение с AMQP
$connection = new AMQPConnection();
$connection->setHost('127.0.0.1');
$connection->setLogin('vagrant');
$connection->setPassword('vagrant');
$connection->connect();

// Канал связи
$channel = new AMQPChannel($connection);

/*
2. Создать несколько очередей.
*/
AMQPQueueCreate($channel, 'task1');
AMQPQueueCreate($channel, 'task2');
AMQPQueueCreate($channel, 'task3');


/*
3. Реализовать цепочку «Заказ еды — оплата — доставка — отзыв клиента». Сколько понадобится очередей?
*/
// заказ от клиента
AMQPQueueCreate($channel, 'order_food');
// подтверждение о том, что заказ создан, ожидается оплата...
AMQPQueueCreate($channel, 'payment_waiting');
// получение оплаты от клиента
AMQPQueueCreate($channel, 'payment_enter');
// подтверждение оплаты
AMQPQueueCreate($channel, 'payment_confirm');
// передача в отдел доставки
AMQPQueueCreate($channel, 'delivery_dept');
// процесс доставки
AMQPQueueCreate($channel, 'delivery_process');
// подтверждение о том, что заказ доставлен
AMQPQueueCreate($channel, 'delivery_confirm');
// попросить клиента оставить отзыв
AMQPQueueCreate($channel, 'ask_feedback');


/**
 * Создание очереди AMQP
 *
 * @param AMQPChannel $channel
 * @param string $name
 * @return void
 */
function AMQPQueueCreate(AMQPChannel $channel, string $name)
{
  try {
  $queue = new AMQPQueue($channel);
  $queue->setName($name);
  $queue->setFlags(AMQP_DURABLE);
  $queue->declareQueue();
} catch (Exception $ex) {
  print_r($ex);
}
}
