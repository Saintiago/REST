<?php
    class myUser extends sfGuardSecurityUser
    {
        public function Authenticate(sfWebRequest $request)
        {
            $result = true;
            $message = "";
            if (!$this->isAuthenticated())
            {
                $server = $request->getPathInfoArray();
                if (isset($server['PHP_AUTH_USER']))
                {
                    $request->setParameter('signin', array(
                        'username' => $server['PHP_AUTH_USER'],
                        'password' => $server['PHP_AUTH_PW'],
                    ));

                    $this->form = new sfGuardFormSignin( array(), array(), false);

                    $this->form->bind($request->getParameter('signin'));
                    if ($this->form->isValid())
                    {
                        $values = $this->form->getValues();
                        $this->signin($values['user']);
                        $result = true;
                    }
                    else
                    {
                        $result = false;
                        $message = $this->form->getErrorSchema();
                    }
                }
                else
                {
                    $result = false;
                    $message = sfConfig::get('app_mess_auth_required');
                }
                
            }
            return array(
                "result" => $result,
                "message" => $message
            );
        }

    }
