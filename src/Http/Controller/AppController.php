<?php

namespace Jimmy\hmifOfficial\Http\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Jimmy\hmifOfficial\Domain\Entity\News;
use Jimmy\hmifOfficial\Domain\Services\NewsService;
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

        $controller->match('/editUser', [$this, 'editUserAction'])
            ->bind('editUser');

        $controller->get('/newsList', [$this, 'newsListAction'])
            ->bind('newsList');

        $controller->match('/createNews', [$this, 'createNewsAction'])
            ->bind('createNews');

        $controller->get('/changeFeaturedStatus', [$this, 'changeFeaturedStatusAction'])
            ->bind('changeFeaturedStatus');

        $controller->match('/editNews', [$this, 'editNewsAction'])
            ->bind('editNews');

        $controller->get('/deleteNews', [$this, 'deleteNewsAction'])
            ->bind('deleteNews');

        return $controller;

    }

    public function deleteNewsAction(Request $request)
    {
        $user = $this->app['news.repository']->findById($this->app['request']->get('id'));

        $this->app['orm.em']->remove($user);
        $this->app['orm.em']->flush();
        $this->app['session']->getFlashBag()->add(
            'message_success',
            'News deleted successfully'
        );
        return $this->app->redirect($this->app['url_generator']->generate('newsList'));
    }

    public function editNewsAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $em = $this->app['orm.em'];

            $news = $em->getRepository('Jimmy\hmifOfficial\Domain\Entity\News')->findById($request->get('id'));

            $news->setNewsId($request->get('id'));
            $news->setTitle($request->get('contentTitle'));
            $news->setContent($request->get('contentNews'));
            $news->setUpdatedAt(new \DateTime());

            $em->flush();

            return $this->app->redirect($this->app['url_generator']->generate('newsList'));
        }

        $newsInfo = $this->app['news.repository']->findById($request->get('id'));

        return $this->app['twig']->render('in264/editNews.twig', ['infoNews' => $newsInfo]);

//        return json_encode($newsInfo);
    }

    public function changeFeaturedStatusAction(Request $request)
    {
        $news = $this->app['news.repository']->findById($request->get('newsId'));

        NewsService::changeFeaturedStatus($news);
        $this->app['orm.em']->persist($news);
        $this->app['orm.em']->flush();
        $this->app['session']->getFlashBag()->add(
            'message_success',
            'Command completed successfully'
        );

        return $this->app->redirect($this->app['url_generator']->generate('newsList'));
    }

    public function createNewsAction(Request $request)
    {

        if ($request->getMethod() === 'POST') {
            $content = $request->get('contentNews');
            $contentTitle = $request->get('contentTitle');

            $newsInfo = News::create($contentTitle,$content, $this->app['session']->get('uname')['value']);

            $this->app['orm.em']->persist($newsInfo);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('newsList'));
        }

        return $this->app['twig']->render('in264/createNews.twig');
    }

    public function newsListAction()
    {
        $listNews = $this->app['news.repository']->findAll();

        return $this->app['twig']->render('in264/listNews.twig', [
            'newsList' => $listNews
        ]);
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

    public function editUserAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $em = $this->app['orm.em'];
            $userUpdate = $em->getRepository('Jimmy\hmifOfficial\Domain\Entity\User')->findById($request->get('id'));

            $userUpdate->setId($request->get('id'));
            $userUpdate->setPassword($request->get('password'));
            $userUpdate->setRole($request->get('role'));
            $this->app['session']->getFlashBag()->add(
                'message_success',
                'Command completed successfully'
            );

            $em->flush();

            return $this->app->redirect($this->app['url_generator']->generate('listUser'));
        }

        $userInfo = $this->app['user.repository']->findById($request->get('id'));
        return $this->app['twig']->render('in264/editUser.twig', [
            'infoUser' => $userInfo
        ]);
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
        $userInfo = count($this->app['user.repository']->findAll());
        $activeUser = count($this->app['user.repository']->findByStatus("1"));
        $inactiveUser = count($this->app['user.repository']->findByStatus("0"));

        return $this->app['twig']->render('in264/adminHome.twig',['infoUser' => $userInfo, 'active' => $activeUser, 'inactive' => $inactiveUser]);
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
        $infoNews = $this->app['news.repository']->findByFeaturedStatus(1);
        return $this->app['twig']->render('home.twig', ['news' => $infoNews]);
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
