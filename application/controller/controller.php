<?php
/**
 * test git
 */

class CbProfilesManager
{
    private static $settings = array(
        'project1'=>array(),
        'global' => array(
            'entities' => array('emission', 'emitents'),
            'profiles' => array(
                'DEV_CB_GLOBAL_ENG',
                'DEV_CB_GLOBAL_ITA',
                //'DEV_CB_GLOBAL_POL',
                'DEV_CB_GLOBAL_RUS',
                'DEV_CB_GLOBAL_DEU',
                'DEV_CB_GLOBAL_ESP',
                'MAIN_CB_GLOBAL_ENG',
                'MAIN_CB_GLOBAL_ITA',
                //'MAIN_CB_GLOBAL_POL',
                'MAIN_CB_GLOBAL_RUS',
                'MAIN_CB_GLOBAL_DEU',
                'MAIN_CB_GLOBAL_ESP',
            ),
        ),
        'test1' => array(),
    );
#end settings

    /**
     * ¬озвращает установки ограничений дл€ указанного профил€ в формате:
     * array(
     *      {alias} => array('allow' => array({allowed_values}), 'disallow' => array({disallowed_values})),
     *      ...
     * )
     *
     * @param string $profileSid -  SID профил€, дл€ которого нужны ограничени€
     *
     * @return array
     */
    private function getProfileRestrictions($profileSid = null)
    {
        $groupName = $this->getProfileGroupName($profileSid);
        $restrictions = array();
        if (isset(self::$settings[$groupName])) {
            $settings = self::$settings[$groupName];
            foreach (array('allow', 'disallow') as $section) {
                if (!empty($settings[$section])) {
                    foreach ($settings[$section] as $alias => $values) {
                        $restrictions[$alias][$section] = $values;
                    }
                }
            }
        }
        // test
        print_r($restrictions);
        return $restrictions;
    }
}