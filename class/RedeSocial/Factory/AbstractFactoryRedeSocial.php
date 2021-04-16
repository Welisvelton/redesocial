<?php

namespace RedeSocial\Factory;

use RedeSocial\Facebook;
use RedeSocial\Instagram;
use RedeSocial\TikTok;

interface AbstractFactoryRedeSocial
{
    public function criarFacebook(): Facebook;
    public function criarInstagram(): Instagram;
    public function criarTikTok(): TikTok;
}
