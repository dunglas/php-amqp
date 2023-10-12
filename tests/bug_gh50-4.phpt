--TEST--
Channel creation race condition (https://github.com/pdezwart/php-amqp/issues/50) (4)
--SKIPIF--
<?php
if (!extension_loaded("amqp")) print "skip AMQP extension is not loaded";
elseif (!getenv("PHP_AMQP_HOST")) print "skip PHP_AMQP_HOST environment variable is not set";
?>
--FILE--
<?php
$cnn = new AMQPConnection();
$cnn->setHost(getenv('PHP_AMQP_HOST'));
$cnn->connect();

$channels = array();

for ($i = 0; $i < 3; $i++) {

    $channel = $channels[] = new AMQPChannel($cnn);
    var_dump($channel->getChannelId());

    $queue = new AMQPQueue($channel);
    $queue->setName('test' . $i);

    $queue->declareQueue();
    $queue->delete();
}

$cnn = new AMQPConnection();
$cnn->setHost(getenv('PHP_AMQP_HOST'));
$cnn->connect();

for ($i = 0; $i < 3; $i++) {

    $channel = $channels[] = new AMQPChannel($cnn);
    var_dump($channel->getChannelId());

    $queue = new AMQPQueue($channel);
    $queue->setName('test' . $i);

    $queue->declareQueue();
    $queue->delete();
}


?>
==DONE==
--EXPECT--
int(1)
int(2)
int(3)
int(1)
int(2)
int(3)
==DONE==
