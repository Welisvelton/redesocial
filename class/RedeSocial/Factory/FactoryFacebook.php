<?php

namespace RedeSocial\Factory;

use RedeSocial\aRedeSocial;
use RedeSocial\Facebook;
class FactoryFacebook implements FactoryRedeSocial
{
  public function criarRedeSocial():aRedeSocial
  {
    return new Facebook("Facebook", "Tenha até 5 mil amigos aqui!");
  }

}