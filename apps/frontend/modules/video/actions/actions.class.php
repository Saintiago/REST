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
            $arInfo = VideoPeer::getInfo($request->getParameter('id'));
            
            $this->forward404Unless(!empty($arInfo));
            
            $this->getResponse()->setContentType('application/json');
           
            return $this->renderText(json_encode($arInfo));
        }

        public function executeNew(sfWebRequest $request)
        {
            $this->form = new UploadVideoForm();
        }

        public function executePost(sfWebRequest $request)
        {
            $this->forward404Unless($request->isMethod(sfRequest::POST));

            $this->form = new UploadVideoForm();

            $this->processForm($request, $this->form);

            $this->setTemplate('new');
        }

        public function executeEdit(sfWebRequest $request)
        {
            $this->forward404Unless($video = VideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object video does not exist (%s).', $request->getParameter('id')));
            $this->form = new UploadVideoForm($video);
        }

        public function executePut(sfWebRequest $request)
        {
            $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
            $this->forward404Unless($video = VideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object video does not exist (%s).', $request->getParameter('id')));
            $this->form = new UploadVideoForm($video);

            $this->processForm($request, $this->form);

            $this->setTemplate('edit');
        }

        public function executeDelete(sfWebRequest $request)
        {
            //$request->checkCSRFProtection();

            $this->forward404Unless($video = VideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object video does not exist (%s).', $request->getParameter('id')));
            $video->delete();

            $this->redirect('video/index');
        }

        protected function processForm(sfWebRequest $request, sfForm $form)
        {
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid())
            {
                $form->save();
            }
        }

    }
