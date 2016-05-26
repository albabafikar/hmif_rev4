<?php

namespace Jimmy\hmifOfficial\Http\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Jimmy\hmifOfficial\Http\Form\LoginForm;
use Jimmy\hmifOfficial\Domain\Entity\User;
use Jimmy\hmifOfficial\Http\Form\UserForm;
use Jimmy\hmifOfficial\Domain\Services\UserPasswordMatcher;
use Jimmy\hmifOfficial\Domain\Services\UserServices;

class AppController implements ControllerProviderInterface
{
	private $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function connect(Application $app)
	{
		$controller = $app['controllers_factory'];

        $controller->get('/error404', [$this, 'errorPageAction'])
            ->bind('errorPage');

		$controller->get('/home',[$this, 'homeAction'])
		->bind('home');

        $controller->match('/loginAdmin', [$this, 'adminLoginAction'])
            ->before([$this, 'checkUserRole'])
            ->bind('loginAdmin');

        $controller->get('/homeAdmin',[$this, 'homeAdminAction'])
            ->before([$this, 'checkUserRole'])
            ->bind('homeAdmin');

        $controller->get('/listUser', [$this, 'showAllUser'])
//            ->before([$this, 'checkUserException'])
            ->bind('listUser');

        $controller->get('/updateManual', [$this, 'coba'])
            ->bind('something');

        $controller->get('/createManual', [$this, 'selfCreateAction'])
            ->bind('selfCreate');

        $controller->get('/logout', [$this, 'logoutAction'])
            ->bind('logout');

        $controller->match('/newUser',[$this, 'newUserAction'])
            ->before([$this, 'checkUserException'])
            ->bind('newInputUser');

        $controller->get('/detail', [$this, 'userDetailAction'])
            ->bind('userDetail');

        $controller->get('/changeStatus/{id}',[$this, 'suspendUserAction'])
            ->bind('suspendUser');

        $controller->get('/delete/{id}', [$this, 'deleteUserAction'])
            ->bind('deleteUser');

		return $controller;

	}

    public function errorPageAction()
    {
        return $this->app['twig']->render('in264/error404.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUserAction()
    {
        $user = $this->app['user.repository']->findById($this->app['request']->get('id'));

        $this->app['orm.em']->remove($user);
        $this->app['orm.em']->flush();
        $this->app['session']->getFlashBag()->add(
            'message_success',
            'Account deleted successfully'
        );

        return $this->app->redirect($this->app['url_generator']->generate('listUser'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function suspendUserAction()
    {
        $user = $this->app['user.repository']->findById($this->app['request']->get('id'));
        UserServices::changeStatus($user);

        $this->app['orm.em']->persist($user);
        $this->app['orm.em']->flush();
        $this->app['session']->getFlashBag()->add(
            'message_success',
            'Command completed successfully'
        );

        return $this->app->redirect($this->app['url_generator']->generate('listUser'));

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newUserAction(Request $request)
    {
        $newUserForm = new UserForm();
        $formBuilder = $this->app['form.factory']->create($newUserForm, $newUserForm);

        if ($request->getMethod() === 'GET') {
            return $this->app['twig']->render('in264/newUser.twig', ['form' => $formBuilder->createView()]);
        }

        $formBuilder->handleRequest($request);

        if (! $formBuilder->isValid()) {
            return $this->app['twig']->render('in264/newUser.twig', ['form' => $formBuilder->createView()]);
        }

        $dataUser = User::create($newUserForm->getUsername(),$newUserForm->getPassword(),$newUserForm->getRole());

        $this->app['orm.em']->persist($dataUser);
        $this->app['orm.em']->flush();

        $this->app['session']->getFlashBag()->add(
            'message_success',
            'Account Created Successfully'
        );
        return $this->app->redirect($this->app['url_generator']->generate('listUser'));
    }

    /**
     * @return string
     */
    public function coba()
    {
        $infoUser = new User();
        $something = $this->app['session']->get('uid')['value'];

        $infoUser->setId($something);
        $infoUser->setUsername($this->app['session']->get('uname')['value']);
        $infoUser->setPassword($infoUser->getPassword());
        $infoUser->setCreatedAt($infoUser->getCreatedAt());
        $infoUser->setRole($infoUser->getRole());
        $infoUser->setStatus($infoUser->getStatus());
        $infoUser->setLastLogin(new \DateTime());

        $this->app['orm.em']->merge($infoUser);
        $this->app['orm.em']->flush();

        return 'sukses';
    }

    /**
     * @return mixed
     */
    public function showAllUser()
    {

        $user = $this->app['user.repository']->findAll();
        $infoUser = $this->app['session']->get('role');

        return $this->app['twig']->render('in264/listUser.twig',['userList' => $user,'infoUser' => $infoUser]);


    }

    public function homeAdminAction()
    {
        return $this->app['twig']->render('in264/adminHome.twig');
    }

    /**
     * @return mixed
     */
    public function selfCreateAction()
    {
        $userInfo = User::create('afif','password',0);

        $this->app['orm.em']->persist($userInfo);
        $this->app['orm.em']->flush();

        return $this->app['url_generator']->generate('home');
    }

    /**
     * @return mixed
     */
	public function homeAction()
	{
		return $this->app['twig']->render('home.twig');
	}

    public function checkUserRole(Request $request)
    {
        if ($request->getPathInfo() === '/loginAdmin' && $this->app['session']->has('uname')) {
            return $this->app->redirect($this->app['url_generator']->generate('homeAdmin'));
        }

        if (! $this->app['session']->has('uname') && ! ($request->getPathInfo() === '/loginAdmin')) {
            $this->app['session']->getFlashBag()->add(
                'message_error',
                'Please Login First'
            );
            return $this->app->redirect($this->app['url_generator']->generate('loginAdmin'));
        }
    }

    public function checkUserException(Request $request)
    {
        $infoRoles = $this->app['session']->get('role');

        if ($infoRoles['value'] !== 0) {
            return $this->app->redirect($this->app['url_generator']->generate('errorPage'));
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminLoginAction(Request $request)
    {
        $loginForm = new LoginForm();

        $formBuilder = $this->app['form.factory']->create($loginForm, $loginForm);

        if ($request->getMethod() === 'GET') {
            return $this->app['twig']->render('in264/login.twig', ['form' => $formBuilder->createView()]);
        }

        $formBuilder->handleRequest($request);

        if (! $formBuilder->isValid()) {
            return $this->app['twig']->render('in264/login.twig', ['form' => $formBuilder->createView()]);
        }

        $user = $this->app['user.repository']->findByUsername($loginForm->getUsername());

        if ($user === null) {
            $this->app['session']->getFlashBag()->add(
                'message_error',
                'Username Incorrect'
            );
            return $this->app['twig']->render('in264/login.twig', ['form' => $formBuilder->createView()]);
        }

        if (! (new UserPasswordMatcher($loginForm->getPassword(), $user))->match()) {
            $this->app['session']->getFlashBag()->add(
                'message_error',
                'Incorrect Username or Password given'
            );
            return $this->app['twig']->render('in264/login.twig', ['form' => $formBuilder->createView()]);
        }

        if (! (($user->getStatus()) == '0')) {
            $this->app['session']->getFlashBag()->add(
                'message_error',
                'Your Account Has Suspended'
            );
            return $this->app['twig']->render('in264/login.twig', ['form' => $formBuilder->createView()]);
        }

        $this->app['session']->set('role', ['value' => $user->getRole()]);
        $this->app['session']->set('uname', ['value' => $user->getUsername()]);
        $this->app['session']->set('uid', ['value' => $user->getId()]);


        $infoUser = new User();
        $something = $this->app['session']->get('uid')['value'];

        $infoUser->setId($something);
        $infoUser->setUsername($this->app['session']->get('uname')['value']);
        $infoUser->setPasswordNonHash($user->getPassword());
        $infoUser->setCreatedAt($user->getCreatedAt());
        $infoUser->setRole($user->getRole());
        $infoUser->setStatus($user->getStatus());
        $infoUser->setLastLogin(new \DateTime());

        $this->app['orm.em']->merge($infoUser);
        $this->app['orm.em']->flush();

        return $this->app->redirect($this->app['url_generator']->generate('homeAdmin'));
    }

    public function logoutAction()
    {
        $this->app['session']->clear();

        return $this->app->redirect($this->app['url_generator']->generate('loginAdmin'));
    }




}