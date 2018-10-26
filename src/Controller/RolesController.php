<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index', 'view']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $roles = $this->Roles->find()
            ->where(['estado_id' => 1]);
        $this->set(compact('roles'));
        $this->set('_serialize', ['roles']);
    }
    /**
     * Get Admin method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAdmin() {
        $roles = $this->Roles->find();
        $this->set(compact('roles'));
        $this->set('_serialize', ['roles']);
    }

    public function view($id) {
        $rol = $this->Roles->get($id, [
            'contain' => ['ControllerRoles.Controllers']
        ]);
        
        $this->set(compact('rol'));
        $this->set('_serialize', ['rol']);
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $rol = $this->Roles->newEntity();
        
        if ($this->request->is('post')) {
            $rol = $this->Roles->patchEntity($rol, $this->request->getData());
 
            if ($this->Roles->save($rol)) {
                $code = 200;
                $message = 'El rol fue guardado correctamente';
            } else {
                $message = 'El rol no fue guardado correctamente';
            }
        }
        $this->set(compact('rol', 'message', 'code'));
        $this->set('_serialize', ['rol', 'message', 'code']);
    }
}
