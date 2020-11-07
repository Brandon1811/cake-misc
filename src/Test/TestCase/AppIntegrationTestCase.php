<?php
namespace Misc\Test\TestCase;

use Cake\Log\Log;
use Cake\I18n\FrozenTime;
use Cake\TestSuite\EmailTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * @codeCoverageIgnore
 */
class AppIntegrationTestCase extends TestCase
{
    use EmailTrait;
    use IntegrationTestTrait;

    /**
     * @var $autoFixtures - Do not load all fixtures set in $fixtures for each test,
     */
    public $autoFixtures = false;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        // $this->disableErrorHandlerMiddleware();
        $_SERVER['REMOTE_ADDR'] = '192.168.0.1';

        $this->loadFixtures('Users');
        $this->UsersTable = TableRegistry::get('Users');
    }

    /**
     * @return void
     */
    public function loadSettingsFixtures()
    {
        $this->loadFixtures('Settings', 'SettingOptions', 'SettingGroups', 'UserSettings');
    }

    public function getTooLongString(int $length = 256)
    {
        $dictionary = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = mb_strlen($dictionary, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $dictionary[random_int(0, $max)];
        }

        return implode('', $pieces);
    }

    /**
     * login - sets sesion data to mock logged in user
     *
     * @param string $userName username to login with
     * @return void
     */
    public function loginByEmail(string $email)
    {
        $user = $this->UsersTable->find('auth')->where(['Users.email' => $email])->firstOrFail()->toArray();

        $this->session([
            'Auth' => [
                'User' => $user,
            ],
        ]);
    }

    /**
     * login - sets sesion data to mock logged in user
     *
     * @param string $userName username to login with
     * @return void
     */
    public function loginByUsername(string $username)
    {
        $user = $this->UsersTable->find('auth')->where(['Users.username' => $username])->firstOrFail()->toArray();

        $this->session([
            'Auth' => [
                'User' => $user,
            ],
        ]);
    }

    /**
     * login - sets sesion data to mock logged in user
     *
     * @param string $userName username to login with
     * @return void
     */
    public function loginById(int $id)
    {
        $user = $this->UsersTable->find('auth')->where(['Users.id' => $id])->firstOrFail()->toArray();

        $this->session([
            'Auth' => [
                'User' => $user,
            ],
        ]);
    }

    /**
     * useAjaxRequest
     *
     * @return void
     */
    public function useAjaxRequest()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
    }

    /**
     * logSession
     *
     * @return void
     */
    public function logSession()
    {
        Log::write('debug', '$_requestSession data');
        Log::write('debug', $this->_requestSession);
    }

    /**
     * logResponse
     *
     * @return void
     */
    public function logResponse()
    {
        Log::write('debug', '_response data');
        Log::write('debug', $this->_response);
    }

    /**
     * logFlash
     *
     * @return void
     */
    public function logFlash()
    {
        Log::write('debug', '$_flashMessages data');
        Log::write('debug', $this->_flashMessages);
    }

    /**
     * cleanUpAjax
     *
     * @return void
     */
    public function cleanUpAjax()
    {
        unset($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    /**
     * Clears session
     *
     * @return void
     */
    public function clearSession()
    {
        $this->_session = [];
    }
}
