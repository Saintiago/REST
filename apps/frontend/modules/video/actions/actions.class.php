<?php
    /**
     * video actions.
     *
     * @package    rest
     * @subpackage video
     * @author     Your name here
     */
    class videoActions extends sfActions
    {

        public function executeIndex(sfWebRequest $request)
        {
            $this->videos = VideoPeer::doSelect(new Criteria());
        }

        public function executeInfo(sfWebRequest $request)
        {
            $user = $this->getUser();
            $authResult = $user->Authenticate($request);
            $message = $authResult["message"];
            if ($authResult["result"])
            {
                $this->forward404Unless(
                    $video = VideoPeer::retrieveByPk($request->getParameter('id')), 
                    sprintf('Object video does not exist (%s).', $request->getParameter('id'))
                );
                $video_owner = $video->getUserID();
                $cur_user = $user->getGuardUser()->getId();

                if ($cur_user == $video_owner)
                {
                    $arInfo = array(
                        "name" => $video->getName(),
                        "width" => $video->getWidth(),
                        "height" => $video->getHeight(),
                        "video_bitrate" => $video->getVideoBitrate(),
                        "audio_bitrate" => $video->getAudioBitrate()
                    );
                    $this->getResponse()->setContentType('application/json');
                    return $this->renderText(json_encode($arInfo));
                }

                $message = sfConfig::get('app_mess_denied');
            }

            $header_message = "Basic realm=\"$message\"";

            $this->getResponse()->setStatusCode('401');
            $this->getResponse()->setHttpHeader('WWW_Authenticate', $header_message);

            return sfView::NONE;
        }

        public function executeNew(sfWebRequest $request)
        {
            $this->form = new UploadVideoForm();
        }

        public function executePost(sfWebRequest $request)
        {
            $user = $this->getUser();
            $authResult = $user->Authenticate($request);
            $message = $authResult["message"];
            if ($authResult["result"])
            {
                $this->forward404Unless($request->isMethod(sfRequest::POST));
                $cur_user = $user->getGuardUser()->getId();
                $this->form = new UploadVideoForm(null, array('user_id' => $cur_user));

                if ($this->processForm($request, $this->form))
                {
                    $this->getResponse()->setStatusCode('200');
                    return sfView::NONE;
                }
                else
                {
                    $message = $this->form->getErrorSchema();
                    echo $message;
                    die();
                }
            }
            else
            {
                $header_message = "Basic realm=\"$message\"";

                $this->getResponse()->setStatusCode('401');
                $this->getResponse()->setHttpHeader('WWW_Authenticate', $header_message);

                return sfView::NONE;
            }

        }

        public function executeEdit(sfWebRequest $request)
        {
            $this->forward404Unless(
                $video = VideoPeer::retrieveByPk($request->getParameter('id')), 
                sprintf('Object video does not exist (%s).', $request->getParameter('id'))
            );
            $this->form = new UploadVideoForm($video);
        }

        public function executePut(sfWebRequest $request)
        {
            $user = $this->getUser();
            $authResult = $user->Authenticate($request);
            $message = $authResult["message"];
            if ($authResult["result"])
            {
                $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
                $this->forward404Unless(
                    $video = VideoPeer::retrieveByPk($request->getParameter('id')), 
                    sprintf('Object video does not exist (%s).', $request->getParameter('id'))
                );
                $this->form = new UploadVideoForm($video);

                if ($this->processForm($request, $this->form))
                {
                    $this->getResponse()->setStatusCode('200');
                    return sfView::NONE;
                }
                else
                {
                    $message = $this->form->getErrorSchema();
                    echo $message;
                    die();
                }
            }
            else
            {
                $header_message = "Basic realm=\"$message\"";

                $this->getResponse()->setStatusCode('401');
                $this->getResponse()->setHttpHeader('WWW_Authenticate', $header_message);

                return sfView::NONE;
            }
        }

        public function executeDelete(sfWebRequest $request)
        {
            $user = $this->getUser();
            $authResult = $user->Authenticate($request);
            $message = $authResult["message"];
            if ($authResult["result"])
            {
                $this->forward404Unless(
                    $video = VideoPeer::retrieveByPk($request->getParameter('id')), 
                    sprintf('Object video does not exist (%s).', $request->getParameter('id'))
                );
                $video_owner = $video->getUserID();
                $cur_user = $user->getGuardUser()->getId();

                if ($cur_user == $video_owner)
                {
                    $video->delete();
                    $this->getResponse()->setStatusCode('200');
                    return sfView::NONE;
                }

                $message = sfConfig::get('app_mess_denied');
            }
            $header_message = "Basic realm=\"$message\"";

            $this->getResponse()->setStatusCode('401');
            $this->getResponse()->setHttpHeader('WWW_Authenticate', $header_message);

            return sfView::NONE;
        }

        protected function processForm(sfWebRequest $request, sfForm $form)
        {
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid())
            {
                $form->save();
                return true;
            }
            else
            {
                return false;
            }
        }

    }
