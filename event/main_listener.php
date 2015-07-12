<?php
/**
 *
 * Open Reports
 *
 * @copyright (c) 2015 Matt Eskridge
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cosmic\openreports\event;

use phpbb\auth\auth;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Global listener.
 */
class main_listener implements EventSubscriberInterface
{
    /** @var \phpbb\config\config */
    protected $config;
    /** @var \phpbb\db\driver\driver_interface */
    protected $db;
    /** @var \phpbb\request\request */
    protected $request;
    /** @var \phpbb\template\template */
    protected $template;
    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\auth|auth */
    protected $auth;

    /** @var string */
    protected $root_path;
    /** @var string */
    protected $php_ext;

    /**
     * Constructor
     *
     * @param \phpbb\config\config $config
     * @param \phpbb\db\driver\driver_interface $db
     * @param \phpbb\request\request $request
     * @param \phpbb\template\template $template
     * @param \phpbb\user $user
     * @param string $root_path
     * @param string $php_ext
     */
    public function __construct(
        $config,
        $db,
        $request,
        $template,
        $user,
        $auth,
        $root_path,
        $php_ext
    )
    {
        $this->config = $config;
        $this->db = $db;
        $this->request = $request;
        $this->template = $template;
        $this->user = $user;
        $this->auth = $auth;

        $this->root_path = $root_path;
        $this->php_ext = $php_ext;
    }

    /**
     * Gets core events subscribed to.
     *
     * @return array   Returns teh core events with their callbacks.
     */
    static public function getSubscribedEvents()
    {
        return array(
            'core.user_setup' => 'user_setup',
        );
    }

    /**
     * Adds common lang data to every page.
     *
     * @param array $event   Array containing situational data.
     */
    public function user_setup($event)
    {
        //$lang_set_ext = $event['lang_set_ext'];
        //$lang_set_ext[] = array(
        //    'ext_name' => 'cosmic/openreports',
        //    'lang_set' => 'openreports_common',
        //);
        //$event['lang_set_ext'] = $lang_set_ext;

        $this->user->add_lang_ext("cosmic/openreports", "openreports_common");

        if ($this->auth->acl_get("m_report") == 0) {
            return;
        }

        // For regular reports
        $sql = "SELECT COUNT(report_id) as num FROM ".REPORTS_TABLE." WHERE report_closed='0' AND pm_id='0'";
        $result = $this->db->sql_query($sql);
        $num = $this->db->sql_fetchfield("num");

        if ($num > 0) {
            $this->template->assign_vars(array(
                "U_REPORTS_LINK" => append_sid("mcp.".$this->php_ext."?i=reports"),
                "U_REPORTS_TOTAL" => $this->user->lang("OPEN_REPORTS", (int) $num)
            ));
        }

        $this->db->sql_freeresult($result);

        // For PM Reports
        $sql = "SELECT COUNT(report_id) as num FROM ".REPORTS_TABLE." WHERE report_closed='0' AND pm_id!='0'";
        $result = $this->db->sql_query($sql);
        $num = $this->db->sql_fetchfield("num");

        if ($num > 0) {
            $this->template->assign_vars(array(
                "U_PM_REPORTS_LINK" => append_sid("mcp.".$this->php_ext."?i=mcp_pm_reports&mode=pm_reports"),
                "U_PM_REPORTS_TOTAL" => $this->user->lang("OPEN_PM_REPORTS", (int) $num)
            ));
        }

        $this->db->sql_freeresult($result);
    }

}