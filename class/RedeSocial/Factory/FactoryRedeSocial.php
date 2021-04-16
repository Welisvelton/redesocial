<?php

namespace RedeSocial\Factory;

use RedeSocial\Facebook;
use RedeSocial\Instagram;
use RedeSocial\TikTok;

class FactoryRedeSocial implements AbstractFactoryRedeSocial
{
  public function criarFacebook(): Facebook
  {
    return new Facebook("Facebook", "");
  }

  public function criarInstagram(): Instagram
  {
    return new Instagram("Instagram", "");
  }

  public function criarTikTok(): TikTok
  {
    return new TikTok("TikTok", "");
  }
}
