<?php
namespace S12g\ImageAttachments\Drivers;

interface DriverInterface {
  public function __construct($config);
  public function saveImage($filename);
  public static function getConfigItems();
}