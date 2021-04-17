<?php

namespace RedeSocial\Factory;

use RedeSocial\Facebook;


class FactoryFacebook implements FactoryRedeSocial
{
  public function criarRedeSocial(): Facebook
  {
    return new Facebook("Facebook", "Tenha até 5 mil amigos aqui!");
  }

}
