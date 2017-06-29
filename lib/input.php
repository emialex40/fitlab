<?php
/**
 * Очистка переменных.
 * IP и USER-AGENT клиента.
 * 
 * @version 1.4
 */
class Input
{
	/**
	 * Разделитель по умолчанию.
	 */	
	const SEPARATOR = ','; 	

	/**
	 * Учитывать копейки для цен (методы cleanPrice() и getPrice()).
	 */	
	const DECIMAL_PRICE = true; 

	/**
	 * Возвращает используемый разделитель.
	 * 
	 * @param string $value	 
	 * @return string
	 */
	private static function _getSeparator($value = null)
	{
		return (is_null($value)) ? self::SEPARATOR : $value;
	}

	/**
	 * Предварительная обработка строки.
	 * 
	 * @param mixed $value	 
	 * @return string
	 */
	private static function _prepare($value)
	{
		$value = strval($value);
		$value = stripslashes($value);
		$value = str_ireplace(array("\0", "\a", "\b", "\v", "\e", "\f"), ' ', $value);
		$value = htmlspecialchars_decode($value, ENT_QUOTES);	

		return $value;
	}

	/**
     * Логический тип (0 или 1).
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return int
     */
	public static function cleanBool($value, $default = 0)
	{
		$value = self::_prepare($value);
		$value = mb_ereg_replace('[\s]', '', $value);
		$value = str_ireplace(array('-', '+', 'false', 'null'), '', $value);

		return (empty($value)) ? $default : 1;
	}

	/**
     * Логический тип для неинициализированных переменных.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return int
     */
	public static function getBool(& $value, $default = 0)
	{
		return self::cleanBool($value, $default);
	}

	/**
     * Логический тип для массива.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию для элементов
	 * @return array
     */
	public static function getArrayBool(& $value, $default = 0)
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanBool($row, $default);
		}
		
		return $res;
	}

	/**
     * Логический тип для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param int $default      Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListBool(& $value, $default = 0, $separator = null)
	{
		return implode(self::_getSeparator($separator), self::getArrayBool($value, $default));		
	}
	
	/**
     * Целое положительное число.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return int
     */
	public static function cleanInt($value, $default = 0)
	{
		$value = self::_prepare($value);
		$value = mb_ereg_replace('[\s]', '', $value);	
		$value = abs(intval($value));

		return (empty($value)) ? $default : $value;
	}

	/**
     * Целое положительное число для неинициализированных переменных.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return int
     */
	public static function getInt(& $value, $default = 0)
	{
		return self::cleanInt($value, $default);
	}

	/**
     * Целое положительное число для массива.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return array
     */
	public static function getArrayInt(& $value, $default = 0)
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanInt($row, $default);
		}

		return $res;
	}
	
	/**
     * Целое положительное число для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param int $default      Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListInt(& $value, $default = 0, $separator = null)
	{
		return implode(self::_getSeparator($separator), self::getArrayInt($value, $default));
	}

	/**
     * Число с плавающей точкой. Может быть отрицательным.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return float
     */
	public static function cleanFloat($value, $default = 0)
	{
		$value = self::_prepare($value);
		$value = mb_ereg_replace('[\s]', '', $value);	
		$value = str_replace(',', '.', $value);
		$value = floatval($value);

		return (empty($value)) ? $default : $value;
	}

	/**
     * Число с плавающей точкой для неинициализированных переменных.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return float
     */
	public static function getFloat(& $value, $default = 0)
	{
		return self::cleanFloat($value, $default);
	}

	/**
     * Число с плавающей точкой для массива.
	 * 
	 * @param mixed $value Значение
	 * @param int $default Значение по умолчанию
	 * @return array
     */
	public static function getArrayFloat(& $value, $default = 0)
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanFloat($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Число с плавающей точкой для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param int $default      Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListFloat(& $value, $default = 0, $separator = null)
	{
		$separator = self::_getSeparator($separator);
		if (in_array($separator, array('.', '-'))) {
			trigger_error('You can not use "' . $separator . '" as a separator', E_USER_ERROR);
		} else {
			return implode($separator, self::getArrayFloat($value, $default));
		}
	}
	
	/**
     * Цена.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение если цена не указана
	 * @param bool $decimal  Учитывать копейки для цен (если не указано используется self::DECIMAL_PRICE)
	 * @return string
     */
	public static function cleanPrice($value, $default = 0, $decimal = null)
	{
		$value = self::_prepare($value);
		$value = mb_ereg_replace('[^0-9\.,]', '', $value);	
		$value = mb_ereg_replace('[,]+', ',', $value);	
		$value = mb_ereg_replace('[.]+', '.', $value);			

		$pos_1 = mb_strpos($value, '.');
		$pos_2 = mb_strpos($value, ',');		
		
		$decimal = (is_null($decimal)) ? self::DECIMAL_PRICE : $decimal;
		if ($decimal) {
			if ($pos_1 && $pos_2) {
				// 1,000,000.00
				$value = mb_substr($value . '00', 0, $pos_1 + 3);
				$value = str_replace(',', '', $value);
			} elseif ($pos_1) {
				// 1000000.00
				$value = mb_substr($value . '00', 0, $pos_1 + 3);
			} elseif ($pos_2) {
				if ((mb_strlen($value) - $pos_2) == 3) {
					// 10,00
					$value = str_replace(',', '.', $value);
				} else {
					// 100,000,000
					$value = str_replace(',', '', $value) . '.00';
				}
			} elseif (mb_strlen($value) == 0) {
				return $default;
			} else {
				$value = $value . '.00';
			}

			return ($value == '0.00') ? 0 : $value;
		} else {
			if ($pos_1 && $pos_2) {
				// 1,000,000.00
				$value = mb_substr($value, 0, $pos_1);
				$value = str_replace(',', '', $value);
			} elseif ($pos_1) {
				// 1000000.00
				$value = mb_substr($value, 0, $pos_1);
			} elseif ($pos_2) {
				// 100,000,000
				$value = str_replace(',', '', $value);
			}
			
			return (mb_strlen($value) == 0) ? $default : intval($value);
		}
	}

	/**
     * Цена для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение если цена не указана
	 * @param bool $decimal  Учитывать копейки для цен (если не указано используется self::DECIMAL_PRICE)
	 * @return string
     */
	public static function getPrice(& $value, $default = 0, $decimal = null)
	{
		return self::cleanPrice($value, $default, $decimal);
	}

	/**
     * Цена для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение если цена не указана
	 * @param bool $decimal  Учитывать копейки для цен (если не указано используется self::DECIMAL_PRICE)
	 * @return string
     */
	public static function getArrayPrice(& $value, $default = 0, $decimal = null)
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanPrice($row, $default, $decimal);
		}
		
		return $res;
	}
	
	/**
     * Цена для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение если цена не указана
	 * @param bool $decimal     Учитывать копейки для цен (если не указано используется self::DECIMAL_PRICE)
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListPrice(& $value, $default = 0, $decimal = null, $separator = null)
	{
		$separator = self::_getSeparator($separator);
		if ($separator == '.') {
			trigger_error('You can not use "' . $separator . '" as a separator', E_USER_ERROR);
		} else {
			return implode($separator, self::getArrayPrice($value, $default, $decimal));
		}
	}
	
	/**
     * Текст.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function cleanText($value, $default = '')
	{
		$value = self::_prepare($value);
		$value = str_ireplace(array("\t"), ' ', $value);			
		$value = preg_replace(array(
			'@<\!--.*?-->@s',                // комментарии HTML "<!-- ... -->"
			'@\/\*(.*?)\*\/@sm',             // многострочные комментарии "/* ... */"
			'@<([\?\%]) .*? \\1>@sx',        // встроенный PHP, Perl, ASP код    
			'@<\!\[CDATA\[.*?\]\]>@sx',      // блоки CDATA "<![CDATA[...]]>"
			'@<\!\[.*?\]>.*?<\!\[.*?\]>@sx', // MS Word тэги типа "<![if! vml]>...<![endif]>" и IE <!--[if expression]>...<![endif]-->       	
			'@\s--.*@',                      // комментарии SQL " --..."
			'@<script[^>]*?>.*?</script>@si',
			'@<style[^>]*?>.*?</style>@siU', 
			'@<[\/\!]*?[^<>]*?>@si',			
		), ' ', $value);		
		$value = strip_tags($value); 		
		$value = str_replace(array('/*', '*/', ' --', '#__'), ' ', $value); 
		$value = mb_ereg_replace('[ ]+', ' ', $value);			
		$value = trim($value);
		$value = htmlspecialchars($value, ENT_QUOTES);	

		return (mb_strlen($value) == 0) ? $default : $value;
	}

	/**
     * Текст для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getText(& $value, $default = '')
	{
		return self::cleanText($value, $default);
	}

	/**
     * Текст для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getArrayText(& $value, $default = '')
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanText($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Текст для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListText(& $value, $default = '', $separator = null)
	{
		$separator = self::_getSeparator($separator);
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = str_ireplace($separator, '', self::cleanText($row, $default));
		}
		
		return implode($separator, $res);
	}

	/**
     * Строка.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function cleanStr($value, $default = '')
	{
		$value = self::cleanText($value);
		$value = str_ireplace(array("\r", "\n"), ' ', $value);
		$value = mb_ereg_replace('[\s]+', ' ', $value);			
		$value = trim($value);

		return (mb_strlen($value) == 0) ? $default : $value;
	}

	/**
     * Строка для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getStr(& $value, $default = '')
	{
		return self::cleanStr($value, $default);
	}

	/**
     * Строка для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getArrayStr(& $value, $default = '')
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanStr($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Строка для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListStr(& $value, $default = '', $separator = null)
	{
		$separator = self::_getSeparator($separator);
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = str_ireplace($separator, '', self::cleanStr($row, $default));
		}

		return implode($separator, $res);
	}
	
	/**
     * Заголовок / название.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function cleanTitle($value, $default = '')
	{
		$value = self::cleanStr($value);
		$value = trim($value, ' .,');

		return $value;
	}

	/**
     * Заголовок / название для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getTitle(& $value, $default = '')
	{
		return self::cleanTitle($value, $default);
	}

	/**
     * Заголовок / название для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getArrayTitle(& $value, $default = '')
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanTitle($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Заголовок / название для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListTitle(& $value, $default = '', $separator = null)
	{
		$separator = self::_getSeparator($separator);
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = str_ireplace($separator, '', self::cleanTitle($row, $default));
		}
		
		return implode($separator, $res);
	}

	/**
     * HTML.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function cleanHtml($value, $default = '')
	{
		$value = self::_prepare($value);
		$value = mb_ereg_replace('[ ]+', ' ', $value);
		$value = trim($value);		
		$value = addslashes($value);

		return (mb_strlen($value) == 0) ? $default : $value;
	}

	/**
     * HTML для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getHtml(& $value, $default = '')
	{
		return self::cleanHtml($value, $default);
	}

	/**
     * ЧПУ.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function cleanSef($value, $default = '')
	{
		$value = self::cleanStr($value, '');
		if (empty($value)) {
			$value = self::cleanStr($default);
		}

		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '',    'ы' => 'y',   'ъ' => '',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);

		$value = strtr($value, $converter);
		$value = mb_strtolower($value);	
		$value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
		$value = mb_ereg_replace('[-]+', '-', $value);
		$value = trim($value, '-');			

		return $value;
	}

	/**
     * ЧПУ для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getSef(& $value, $default = '')
	{
		return self::cleanSef($value, $default);
	}

	/**
     * ЧПУ для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getArraySef(& $value, $default = '')
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanSef($row, $default);
		}
		
		return $res;
	}
	
	/**
     * ЧПУ для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR).
	 * @return string
     */
	public static function getListSef(& $value, $default = '', $separator = null)
	{
		$separator = self::_getSeparator($separator);
		if ($separator == '-') {
			trigger_error('You can not use "' . $separator . '" as a separator', E_USER_ERROR);
		} else {
			$res = array();
			foreach ((array) $value as $row) {
				$res[] = str_ireplace($separator, '', self::cleanSef($row, $default));
			}
		
			return implode($separator, $res);
		}
	}

	/**
     * Строка поиска.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function cleanSearch($value, $default = '')
	{
		$value = self::cleanStr($value, $default);
		$value = str_replace(array('_', '%'), ' ', $value); 
		$value = trim($value);

		return (mb_strlen($value) == 0) ? $default : $value;
	}

	/**
     * Строка поиска для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getSearch(& $value, $default = '')
	{
		return self::cleanSearch($value, $default);
	}

	/**
     * Строка поиска для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return string
     */
	public static function getArraySearch(& $value, $default = '')
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanSearch($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Строка поиска для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListSearch(& $value, $default = '', $separator = null)
	{
		$separator = self::_getSeparator($separator);
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = str_ireplace($separator, '', self::cleanSearch($row, $default));
		}
	
		return implode($separator, $res);
	}
	
	/**
     * Имя файла.
	 * 
	 * @param mixed $value    Значение
	 * @param string $default Значение по умолчанию
	 * @return string
     */
	public static function cleanFilename($value, $default = '')
	{
		$value = self::cleanStr($value, $default);
		$value = str_replace(array('/', '|', '\\', '?', ':', ';', '\'', '"', '<', '>', '*'), '', $value);
		$value = mb_ereg_replace('[.]+', '.', $value);
		
		return (mb_strlen($value) == 0) ? $default : $value;
	}

	/**
     * Имя файла для неинициализированных переменных.
	 * 
	 * @param mixed $value    Значение
	 * @param string $default Значение по умолчанию
	 * @return string
     */
	public static function getFilename(& $value, $default = '')
	{
		return self::cleanFilename($value, $default);
	}

	/**
     * Имя файла для массива.
	 * 
	 * @param mixed $value    Значение
	 * @param string $default Значение по умолчанию
	 * @return string
     */
	public static function getArrayFilename(& $value, $default = '')
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanFilename($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Имя файла для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение
	 * @param string $default   Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return string
     */
	public static function getListFilename(& $value, $default = '', $separator = null)
	{
		$separator = self::_getSeparator($separator);
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = str_ireplace($separator, '', self::cleanFilename($row, $default));
		}
	
		return implode($separator, $res);
	}

	/**
     * Unix timestamp.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return int
     */
	public static function cleanTime($value, $default = 0)
	{
		$value = self::cleanStr($value, $default);
		$value = strtotime($value);
		
		return (empty($value)) ? $default : $value;
	}

	/**
     * Unix timestamp для неинициализированных переменных.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return int
     */
	public static function getTime(& $value, $default = 0)
	{
		return self::cleanTime($value, $default);
	}

	/**
     * Unix timestamp для массива.
	 * 
	 * @param mixed $value   Значение
	 * @param mixed $default Значение по умолчанию
	 * @return int
     */
	public static function getArrayTime(& $value, $default = 0)
	{
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = self::cleanTime($row, $default);
		}
		
		return $res;
	}
	
	/**
     * Unix timestamp для массива, результат объединённый в сторку через разделитель.
	 * 
	 * @param mixed $value      Значение 
	 * @param mixed $default    Значение по умолчанию
	 * @param string $separator Разделитель (если не указан используется self::SEPARATOR)
	 * @return int
     */
	public static function getListTime(& $value, $default = 0, $separator = null)
	{
		$separator = self::_getSeparator($separator);
		$res = array();
		foreach ((array) $value as $row) {
			$res[] = str_ireplace($separator, '', self::cleanTime($row, $default));
		}
	
		return implode($separator, $res);
	}

	/**
	 * IP адрес клиента.
	 * 
	 * @param string $default Значение по умолчанию 
	 * @return string
	 */
	public static function getIp($default = '')
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$value = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$value = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
			$value = $_SERVER['REMOTE_ADDR'];
		} else {
			return $default;
		}

		return self::cleanStr($value, $default);
	}

	/**
	 * Юзер-агент клиента.
	 * 
	 * @param string $default Значение по умолчанию 
	 * @return string
	 */
	public static function getUserAgent($default = '')
	{
		return self::getStr($_SERVER['HTTP_USER_AGENT'], $default);
	}
}