<?php 
\Magento\Framework\Component\ComponentRegistrar::register(
   \Magento\Framework\Component\ComponentRegistrar::MODULE,
   'Actiview_Honeypot',
    isset($file) ? dirname($file) : __DIR__
);
