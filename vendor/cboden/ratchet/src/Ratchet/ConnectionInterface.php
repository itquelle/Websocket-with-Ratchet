<?php
namespace Ratchet;
const VERSION = 'Ratchet/0.4.1';

interface ConnectionInterface {

    function send($data);
    function close();

}
