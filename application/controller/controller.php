<?php
/**
 *
 */

class CbProfilesManager
{
    /**
     * Текущий профиль - выставляется в конструкторе инициализирующим приложением
     * @var string
     */
    private $defaultProfileSid;

    /**
     * Настройки групп профилей [groupName => [profiles => [], allow => [], disallow => []], ...]
     *
     * @var array
     */
#if settings
    private static $settings = array(
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
        'pl' => array(
            'entities' => array('emission', 'emitents'),
            'profiles'  => array(
                'DEV_CB_POLAND_ENG',
                'DEV_CB_POLAND_POL',
                'DEV_CB_POLAND_RUS',
                'MAIN_PL_CBONDS_INFO_ENG',
                'MAIN_PL_CBONDS_INFO_RUS',
                'MAIN_CBONDS_PL_PROFILE',
            ),
            'allow'     => array(
                //'country.id'    => 24,
                'emission_show_pl' => 1,
            ),
        ),
        'ru' =>
            array(
                'entities' => array('emission', 'emitents'),
                'profiles'  => array(
                    'DEV_CB_RU_ENG',
                    'DEV_CB_RU_RUS',
                    'MAIN_CB_RU_ENG',
                    'MAIN_CB_RU_RUS',
                ),
                'allow'     => array(
                    'emission_show_ru' => 1,
                ),
            ),
        'ua' => array(
            'entities' => array('emission', 'emitents'),
            'profiles'  => array(
                'DEV_CB_UA_ENG',
                'DEV_CB_UA_RUS',
                'MAIN_CB_UA_COM',
                'MAIN_CB_UA_RUS',
            ),
            'allow'     => array(
                //'country.id'    => 72,
                'emission_show_ua' => 1,
            ),
        ),
        'em' => array(
            'entities' => array('emission', 'emitents'),
            'profiles'  => array(
                'DEV_CB_EM_ENG',
                'DEV_CB_EM_POL',
                'DEV_CB_EM_RUS',
                'DEV_CB_EM_ITA',
                'DEV_CB_EM_DEU',
                'DEV_CB_EM_ESP',
                'MAIN_CB_EM_ENG',
                'MAIN_CB_EM_RUS',
                'MAIN_CB_EM_POL',
                'MAIN_CB_EM_ITA',
                'MAIN_CB_EM_DEU',
                'MAIN_CB_EM_ESP',
            ),
            'allow'     => array(
                //'kind.kind_id' => 2,
                'emission_show_em' => 1,
            ),
            'disallow'  => array(
                //'subregion.id'  => array(7, 9, 11),
                //'kind.kind_id' => 1,
            ),
        ),
        'default' => array(
            'entities' => array('emission', 'emitents'),
            'profiles'  => array(
                'DEV_CBONDS_ENG',
                'DEV_CBONDS_RUS',
                'CBONDS_ENG',
                'CBONDS_RUS',
            ),
        ),
        'loans' => array(
            'entities' => array('loan'),
            'profiles' => array(
                'DEV_LOANS_ENG',
                'DEV_LOANS_RUS',
                'LOANS_ENG',
                'LOANS_RUS',
            ),
        ),
        'old-loans' => array(
            'entities' => array('loan'),
            'profiles' => array(
                'DEV_OLD_LOANS_ENG',
                'DEV_OLD_LOANS_RUS',
                'OLD_LOANS_ENG',
                'OLD_LOANS_RUS',
            ),
        ),
        'old-mm' => array(
            'entities' => array(),
            'profiles' => array(
                'DEV_OLD_MONEY_MARKET',
                'OLD_MONEY_MARKET',
            ),
        ),
        'mm' => array(
            'entities' => array(),
            'profiles' => array(
                'DEV_MONEY_MARKET_RUS',
                'DEV_MONEY_MARKET_ENG',
                'MONEY_MARKET_RUS',
                'MONEY_MARKET_ENG',
            ),
        ),
        'portfolio' => array(
            'entities' => array(),
            'profiles' => array(
                'DEV_PORTFOLIO_CBONDS_INFO_ENG',
                'DEV_PORTFOLIO_CBONDS_INFO_ITA',
                'DEV_PORTFOLIO_CBONDS_INFO_POL',
                'DEV_PORTFOLIO_CBONDS_INFO_RUS',
                'RELEASE_PORTFOLIO_CBONDS_INFO_ENG',
                'RELEASE_PORTFOLIO_CBONDS_INFO_RUS',
                'RELEASE_PORTFOLIO_CBONDS_INFO_ITA',
                'RELEASE_PORTFOLIO_CBONDS_INFO_POL',
            ),
        ),
    );
#end settings

    /**
     * Возвращает установки ограничений для указанного профиля в формате:
     * array(
     *      {alias} => array('allow' => array({allowed_values}), 'disallow' => array({disallowed_values})),
     *      ...
     * )
     *
     * @param string $profileSid -  SID профиля, для которого нужны ограничения
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
        return $restrictions;
    }
}