--TEST--
AMQPConnection setSaslMethod int
--SKIPIF--
<?php
if (!extension_loaded("amqp")) print "skip AMQP extension is not loaded";
elseif (!getenv("PHP_AMQP_HOST")) print "skip PHP_AMQP_HOST environment variable is not set";
?>
--FILE--
<?php
$cnn = new AMQPConnection();
$cnn->setHost(getenv('PHP_AMQP_HOST'));
$cnn->setSaslMethod(0);
var_dump($cnn->getSaslMethod());
$cnn->setSaslMethod(1);
var_dump($cnn->getSaslMethod());
$cnn->setSaslMethod(AMQP_SASL_METHOD_PLAIN);
var_dump($cnn->getSaslMethod());
$cnn->setSaslMethod(AMQP_SASL_METHOD_EXTERNAL);
var_dump($cnn->getSaslMethod());
?>
--EXPECT--
int(0)
int(1)
int(0)
int(1)
