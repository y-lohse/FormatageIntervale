<?php

function formatage(DateTime $debut, DateTime $fin = NULL, Array $options = array()){
	if ($fin === NULL) $fin = $debut;
	$defaults = array( 'uniqueDate'=>'Le %s',
						'uniqueHeure'=>'à %s',
						'intervaleDate'=>'Du %1$s au %2$s',
						'intervaleHeure'=>'de %1$s à %2$s',
						'formatDate'=>'j F',
						'formatHeure'=>'H\hi');
	$options = array_merge($defaults, $options);
	
	$mois = array(	'January'=>'Janvier',
					'February'=>'Février',
					'March'=>'Mars',
					'April'=>'Avril',
					'May'=>'Mai',
					'June'=>'Juin',
					'July'=>'Juillet',
					'August'=>'Août',
					'September'=>'Septembre',
					'October'=>'Octobre',
					'November'=>'Novembre',
					'December'=>'Décembre');
	
	$jours = array('Sunday'=>'Dimanche',
					'Monday'=>'Lundi',
					'Thursday'=>'Mardi',
					'Wednesday'=>'Mercredi',
					'Tuesday'=>'Jeudi',
					'Friday'=>'Vendredi',
					'Saturday'=>'Samedi');
	
	$difference = (int)$fin->format('U')-(int)$debut->format('U');
	$intervaleString = '';
	
	$debutDate = $debut->format($options['formatDate']);
	$debutHeure = $debut->format($options['formatHeure']);
	$finDate = $fin->format($options['formatDate']);
	$finHeure = $fin->format($options['formatHeure']);
	
	if ($difference === 0){
		//même jour, même heure
		$intervaleString = sprintf($options['uniqueDate'], $debutDate);
	}
	else if ($difference < 86400){
		//même jour, pas même heure
		$intervaleString = sprintf($options['uniqueDate'], $debutDate).' '.sprintf($options['intervaleHeure'], $debutHeure, $finHeure);
	}
	else if ($difference%(86400) === 0){
		//pas même jour, même heure
		$intervaleString = sprintf($options['intervaleDate'], $debutDate, $finDate);
	}
	else {
		//pas même jour, pas même heure
		$intervaleString = sprintf($options['intervaleDate'], $debutDate, $finDate).' '.sprintf($options['intervaleHeure'], $debutHeure, $finHeure);
	}
	
	return str_replace(array_merge(array_keys($mois), array_keys($jours)), array_merge($mois, $jours), $intervaleString);
}
/*
class FormatageIntervaleHelper extends AppHelper{
	public $uniqueDate = 'Le %s';
	public $uniqueHeure = 'à %s';
	public $intervaleDate = 'Du %1$s au %2$s';
	public $intervaleHeure = 'de %1$s à %2$s';
	public $formatDate = 'j F';
	public $formatHeure = 'H\hi';
	
	private $mois = array(	'January'=>'Janvier',
							'February'=>'Février',
							'March'=>'Mars',
							'April'=>'Avril',
							'May'=>'Mai',
							'June'=>'Juin',
							'July'=>'Juillet',
							'August'=>'Août',
							'September'=>'Septembre',
							'October'=>'Octobre',
							'November'=>'Novembre',
							'December'=>'Décembre');
	
	private $jours = array('Sunday'=>'Dimanche',
							'Monday'=>'Lundi',
							'Thursday'=>'Mardi',
							'Wednesday'=>'Mercredi',
							'Tuesday'=>'Jeudi',
							'Friday'=>'Vendredi',
							'Saturday'=>'Samedi');
	
	public function formate(DateTime $debut, DateTime $fin = NULL){
		if ($fin === NULL) $fin = $debut;
		$difference = (int)$fin->format('U')-(int)$debut->format('U');
		$intervaleString = '';
		
		$debutDate = $debut->format($this->formatDate);
		$debutHeure = $debut->format($this->formatHeure);
		$finDate = $fin->format($this->formatDate);
		$finHeure = $fin->format($this->formatHeure);
		
		if ($difference === 0){
			//même jour, même heure
			$intervaleString = sprintf($this->uniqueDate, $debutDate);
		}
		else if ($difference < 86400){
			//même jour, pas même heure
			$intervaleString = sprintf($this->uniqueDate, $debutDate).' '.sprintf($this->intervaleHeure, $debutHeure, $finHeure);
		}
		else if ($difference%(86400) === 0){
			//pas même jour, même heure
			$intervaleString = sprintf($this->intervaleDate, $debutDate, $finDate);
		}
		else {
			//pas même jour, pas même heure
			$intervaleString = sprintf($this->intervaleDate, $debutDate, $finDate).' '.sprintf($this->intervaleHeure, $debutHeure, $finHeure);
		}
		
		return str_replace(array_merge(array_keys($this->mois), array_keys($this->jours)), array_merge($this->mois, $this->jours), $intervaleString);
	}
}*/

?>