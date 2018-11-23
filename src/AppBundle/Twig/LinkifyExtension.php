<?php

	namespace AppBundle\Twig;

	class LinkifyExtension extends \Twig_Extension {

		public function getFilters()
		{
			return array(
				new \Twig_SimpleFilter(('linkify'), array($this, 'linkifyFilter'))
			);
		}

		public function linkifyFilter($text)
		{
			return preg_replace('#\b(http|ftp)(s)?\://([^ \s\t\r\n]+?)([\s\t\r\n])+#smui', '<a href="$1$2://$3">$1$2://$3</a>$4', $text);
		}

		public function getName()
		{
			return 'linkify_extension';
		}

	}