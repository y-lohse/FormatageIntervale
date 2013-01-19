<?php
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
	
	public function formate(DateTime $debut, DateTime $fin){
		$difference = (int)$fin->format('U')-(int)$debut->format('U');
		$intervaleString = '';
		
		if ($difference === 0){
			//même jour, même heure
			$intervaleString = sprintf($this->uniqueDate, $debut->format($this->formatDate));
		}
		else if ($difference < 60*60*24){
			//même jour, pas même heure
			$intervaleString = sprintf($this->uniqueDate, $debut->format($this->formatDate)).' '.sprintf($this->intervaleHeure, $debut->format($this->formatHeure), $fin->format($this->formatHeure));
		}
		else if ($difference%(60*60*24) === 0){
			//pas même jour, même heure
			$intervaleString = sprintf($this->intervaleDate, $debut->format($this->formatDate), $fin->format($this->formatDate));
		}
		else {
			//pas même jour, pas même heure
			$intervaleString = sprintf($this->intervaleDate, $debut->format($this->formatDate), $fin->format($this->formatDate)).' '.sprintf($this->intervaleHeure, $debut->format($this->formatHeure), $fin->format($this->formatHeure));
		}
		
		return str_replace(array_keys($this->mois), $this->mois, $intervaleString);
	}
}

?>