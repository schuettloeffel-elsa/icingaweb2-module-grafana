<?php
/**
 * Created by PhpStorm.
 * User: carst
 * Date: 19.02.2018
 * Time: 19:05
 */

namespace Icinga\Module\Grafana\Helpers;

use Icinga\Application\Icinga;


class SpecialVars
{
    private $urlparams;
    private $link;
    private $view;

    public function __construct(array $array = array(), $link = "")
    {
        $this->urlparams = $array;
        $this->link = $link;

        $this->view = Icinga::app()->getViewRenderer()->view;
    }

    private function getSpecialVarsLink($var, $val)
    {
        $this->urlparams[$var] = $val;

        return $this->view->qlink(
            $val,
            $this->link,
            $this->urlparams,
            array(
                'class' => 'action-link',
                'data-base-target' => '_self',
                'title' => 'Set ' . $var . ' for graph(s) to ' . $val
            )
        );
    }


    private function buildSpecialVarsMenu($vars = array())
    {
        $menu = '<table class="grafana-table"><tr>';
        foreach ($vars as $key => $mainValue) {
            $menu .= '<td><ul class="grafana-menu-navigation"><a class="main" href="#">' . ucfirst($key) . '</a>';
            $counter = 1;
            foreach ($mainValue as $subkey => $value) {
                $menu .= '<li class="grafana-menu-n' . $counter . '">' . $this->getSpecialVarsLink($key, $value) . '</li>';
                $counter++;
            }
            $menu .= '</ul></td>';
        }
        $menu .= '</tr></table>';

        return $menu;
    }

    public function getSpecialVarsMenu($vars = array())
    {
        return $this->buildSpecialVarsMenu($vars);
    }

}
