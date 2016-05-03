<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UserController implements \Anax\DI\IInjectionAware
{
        use \Anax\DI\TInjectable;
    use \Anax\MVC\TRedirectHelpers;
        
        
        /**
         * Initialize the controller.
         *
         * @return void
         */
        public function initialize()
        {
            $this->users = new \Anax\Users\User();
            $this->form = new \Mos\HTMLForm\CForm();
            $this->users->setDI($this->di);
        }
        

        public function indexAction() 
        {
            $this->theme->setTitle("Användare");
            //$all = $this->users->findAll();
            
            $all = $this->users->generateUsers();
            
           $this->views->add('me/users', [
           'users' => $all,
           'title' => "Användare",
           ]);
        }

        /**
         * List all users.
         *
         * @return void
         */
        public function listAction()
        {

            $all = $this->users->findAll();
         
            $this->theme->setTitle("List all users");
            $this->views->add('me/users', [
                'users' => $all,
                'title' => "View all users FRÅN USERR",
            ]);
        }
        
        
        
            /**
             * List user with id.
             *
             * @param int $id of user to display
             *
             * @return void
             */
            public function idAction($id = null)
            {

                $user = $this->users->find($id);
             
                $this->theme->setTitle("View user with id");
                $this->views->add('users/view', [
                    'user' => $user,
                    'title' => "Kolla in denna användaren:"
                ]);
            }
            
            
            
            
            public function addAction() 
            {
                //$this->db->setVerbose(true);
                $this->theme->setTitle("Skapa Användare");
                $form = $this->form->create([], [
                        
                        
                        'acronym' => [
                            'type'        => 'text',
                            'label'       => 'Akronym',
                            'required'    => true,
                            'validation'  => ['not_empty'],
                        ],
                        'name' => [
                            'type'        => 'text',
                            'label'       => 'Namn',
                            'required'    => true,
                            'validation'  => ['not_empty'],
                        ],
                        'password' => [
                            'type'        => 'text',
                            'label'       => 'Lösenord',
                            'required'    => true,
                            'validation'  => ['not_empty'],
                        ],
                        'email' => [
                            'type'        => 'text',
                            'label'       => 'Email',
                            'required'    => true,
                            'validation'  => ['not_empty', 'email_adress'],
                        ],
                        'phone' => [
                            'type'        => 'text',
                            'label'       => 'Telefon',
                            'required'    => true,
                            'validation'  => ['not_empty', 'numeric'],
                        ],
                        'submit' => [
                            'type'      => 'submit',
                            'callback'  => function () {
                            
                            $now = gmdate('Y-m-d H:i:s');
                            
                        $this->users->save([
                            'acronym' => $this->form->Value('acronym'),
                            'email' => $this->form->Value('email'),
                            'name' => $this->form->Value('name'),
                            'phone' => $this->form->Value('phone'),
                            'password' => password_hash($this->form->Value('password'), PASSWORD_DEFAULT),
                            'created' => $now,
                            'active' => $now,
                        ]);
                        $url = $this->url->create('user');
                        $this->response->redirect($url);
                        return true;
                            }
                        ],
                        'submit-fail' => [
                            'type'      => 'submit',
                            'callback'  => function () {
                                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                                return false;
                            }
                        ],
                       ]);
                       
                       $form->check();
                                            
                        $this->views->add('default/page', [
                            'title' => "Skapa användare",
                            'content' => $form->getHTML() 
                            ]);
                            
                      
            }
            
            public function updateAction($id) {
                //$this->db->setVerbose(true);
                $this->theme->setTitle("Uppdatera Användare");
                $idHere = $id;
                $form = $this->form->create([], [
                        
                        'id' => [
                            'type'        => 'hidden',
                            'value'                => "{$this->users->findCol('id', $id)}",
                        ],
                        'acronym' => [
                            'type'        => 'text',
                            'label'       => 'Akronym',
                            'required'    => true,
                            'validation'  => ['not_empty'],
                            'value'                => "{$this->users->findCol('acronym', $id)}",
                        ],
                        'name' => [
                            'type'        => 'text',
                            'label'       => 'Namn',
                            'required'    => true,
                            'validation'  => ['not_empty'],
                            'value'                => "{$this->users->findCol('name', $id)}",
                        ],
                        'password' => [
                            'type'        => 'text',
                            'label'       => 'Lösenord',
                            'required'    => true,
                            'validation'  => ['not_empty'],
                            'value'                => "{$this->users->findCol('password', $id)}",
                        ],
                        'email' => [
                            'type'        => 'text',
                            'label'       => 'Email',
                            'required'    => true,
                            'validation'  => ['not_empty', 'email_adress'],
                            'value'                => "{$this->users->findCol('email', $id)}",
                        ],
                        'phone' => [
                            'type'        => 'text',
                            'label'       => 'Telefon',
                            'required'    => true,
                            'validation'  => ['not_empty', 'numeric'],
                            'value'                => "{$this->users->findCol('phone', $id)}",
                        ],
                        'submit' => [
                            'type'      => 'submit',
                            //'value'            => 'Uppdatera',
                            'callback'  => function () {
                            
                            $now = gmdate('Y-m-d H:i:s');
                            
                        $this->users->save([
                                'id'            => $this->form->Value('id'),
                            'acronym' => $this->form->Value('acronym'),
                            'email' => $this->form->Value('email'),
                            'name' => $this->form->Value('name'),
                            'phone' => $this->form->Value('phone'),
                            'password' => password_hash($this->form->Value('password'), PASSWORD_DEFAULT),
                            'updated' => $now,
                        ]);
                        $url = $this->url->create('user');
                        $this->response->redirect($url);
                        return true;
                        
                            }
                        ],
                        'submit-fail' => [
                            'type'      => 'submit',
                            'callback'  => function () {
                                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                                return false;
                            }
                        ],
                       ]);
                       
                       $form->check();
                       
                       $this->views->add('default/page', [
                           'title' => "Uppdatera användare",
                           'content' => $form->getHTML() 
                           ]);
            }
            
                /**
                 * Add new user.
                 *
                 * @param string $acronym of user to add.
                 *
                 * @return void
                 */
            /*    public function addAction($acronym = null)
                {
                    
                    if (!isset($acronym)) {
                        die("Missing acronym");
                    }
                 
                    $now = gmdate('Y-m-d H:i:s');
                 
                    $this->users->save([
                        'acronym' => $acronym,
                        'email' => $acronym . '@mail.se',
                        'name' => 'Mr/Mrs ' . $acronym,
                        'password' => password_hash($acronym, PASSWORD_DEFAULT),
                        'created' => $now,
                        'active' => $now,
                    ]);
                 
                    $url = $this->url->create('users/id/' . $this->users->id);
                    $this->response->redirect($url);
                }
            
            */
            
                
                /**
                 * Delete user.
                 *
                 * @param integer $id of user to delete.
                 *
                 * @return void
                 */
                public function deleteAction($id = null)
                {
                    if (!isset($id)) {
                        die("Missing id");
                    }
                 
                    $res = $this->users->delete($id);
                 
                    $url = $this->url->create('user');
                    $this->response->redirect($url);
                }
                
                public function setupAction() {
                
                    $this->db->dropTableIfExists('user')->execute();
                    
                       $this->db->createTable(
                           'user',
                           [
                               'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                               'acronym' => ['varchar(20)', 'unique', 'not null'],
                               'email' => ['varchar(80)'],
                               'name' => ['varchar(80)'],
                               'password' => ['varchar(255)'],
                               'phone' => ['int(100)'],
                               'created' => ['datetime'],
                               'updated' => ['datetime'],
                               'deleted' => ['datetime'],
                               'active' => ['datetime'],
                           ]
                       )->execute();
                       
                          $this->db->insert(
                              'user',
                              ['acronym', 'email', 'name', 'password', 'phone', 'created', 'active']
                          );
                       
                          $now = gmdate('Y-m-d H:i:s');
                       
                          $this->db->execute([
                              'admin',
                              'admin@dbwebb.se',
                              'Administrator',
                              password_hash('admin', PASSWORD_DEFAULT),
                              56789,
                              $now,
                              $now
                          ]);
                       
                          $this->db->execute([
                              'doe',
                              'doe@dbwebb.se',
                              'John/Jane Doe',
                              password_hash('doe', PASSWORD_DEFAULT),
                              123456,
                              $now,
                              $now
                          ]);
                    
                    $url = $this->url->create('user');
                    $this->response->redirect($url);
                
                }
                
                
                /**
                 * Delete (soft) user.
                 *
                 * @param integer $id of user to delete.
                 *
                 * @return void
                 */
                public function softDeleteAction($id = null)
                {
                    if (!isset($id)) {
                        die("Missing id");
                    }
                 
                    $now = gmdate('Y-m-d H:i:s');
                 
                    $user = $this->users->find($id);
                 
                         $user->active = Null;
                    $user->deleted = $now;
                    $user->save();
                 
                    $url = $this->url->create('user');
                    $this->response->redirect($url);
                }
                
                public function undoSoftDeleteAction($id = null)
                {
                    if (!isset($id)) {
                        die("Missing id");
                    }
                 
                    $now = gmdate('Y-m-d H:i:s');
                 
                    $user = $this->users->find($id);
                 
                         $user->active = $now;
                    $user->deleted = NULL;
                    $user->save();
                 
                    $url = $this->url->create('user');
                    $this->response->redirect($url);
                }
                
                
                
                
                /**
                 * List all active and not deleted users.
                 *
                 * @return void
                 */
                public function activeAction()
                {
                    $all = $this->users->query()
                        ->where('active IS NOT NULL')
                        ->andWhere('deleted is NULL')
                        ->execute();
                 
                    $this->theme->setTitle("Users that are active");
                    $this->views->add('users/list-all', [
                        'users' => $all,
                        'title' => "Users that are active",
                    ]);
                }
                
                public function deletedAction()
                {
                    $all = $this->users->query()
                        ->where('active is NULL')
                        ->andWhere('deleted IS NOT NULL')
                        ->execute();
                 
                    $this->theme->setTitle("Papperskorgen");
                    $this->views->add('users/list-all', [
                        'users' => $all,
                        'title' => "Papperskorgen",
                    ]);
                    
                  }
        

}  