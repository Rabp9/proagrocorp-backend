<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['token']);
    }
    
    public function getAdmin() {        
        $users = $this->Users->find()
            ->contain(['Roles']);
                
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Personal id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id);

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Personal id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $personal = $this->Personal->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $personal = $this->Personal->patchEntity($personal, $this->request->getData());
            if ($this->Personal->save($personal)) {
                $this->Flash->success(__('The personal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The personal could not be saved. Please, try again.'));
        }
        $this->set(compact('personal'));
        $this->set('_serialize', ['personal']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Personal id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $personal = $this->Personal->get($id);
        if ($this->Personal->delete($personal)) {
            $this->Flash->success(__('The personal has been deleted.'));
        } else {
            $this->Flash->error(__('The personal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEntity();
        
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $code = 200;
                $message = 'El usuario fue guardado correctamente';
            } else {
                $message = 'El usuario no fue guardado correctamente';
            }
        }
        $this->set(compact('user', 'message', 'code'));
        $this->set('_serialize', ['user', 'message', 'code']);
    }

    /**
     * Login method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function login() {
        $hasher = new DefaultPasswordHasher();
        
        $user = $this->Users->findByUsername($this->request->getData()['username'])->first();
        
        if (!empty($user)) {
            if (!$hasher->check($this->request->getData()['password'], $user->password)) {
                $user = null;
                $message =  [
                    'text' => __('El password no coincide'),
                    'type' => 'success',
                ];
            } else {
                $user = $this->Users->get($user->id, ['contain' => ['Roles.ControllerRoles.Controllers']]);
            }
        } else {
            $message =  [
                'text' => __('El nombre de usuario no existe'),
                'type' => 'success',
            ];
        }
        
        $this->set(compact('user', 'message'));
        $this->set('_serialize', ['user', 'message']);
    }
    
    public function token() {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }
        $user = $this->Users->get($user['id'], ['contain' => ['Roles.ControllerRoles.Controllers']]);
        $this->set([
            'success' => true,
            'user' => $user,
            'token' => JWT::encode([
                'sub' => $user['id'],
                'exp' =>  time() + 604800
            ],
            Security::salt()),
            '_serialize' => ['success', 'user', 'token']
        ]);
    }
}
