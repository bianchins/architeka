<?php if(isset($feedback)) {
?>
<div id="bouncebox">
<p><b>Notifica</b><?php echo $feedback;?></p>
</div>
<?php 	
}
?>
<script language="JavaScript">
function checkForm()
{
   var cname, cemail, clastname, cphone;
   with(window.document.registerform)
   {
      cfirstname    = firstname;
      cemail   = email;
      clastname = lastname;
      cphone = phone;
      cpiva = piva;
   }

   if(trim(cfirstname.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTNAME;?>');
      cfirstname.focus();
      return false;
   }
   else if(trim(cemail.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_VALIDEMAIL;?>');
      cemail.focus();
      return false;
   }
   else if(!isEmail(trim(cemail.value)))
   {
      alert('<?php echo LANG_JAVASCRIPT_NOTVALIDEMAIL;?>');
      cemail.focus();
      return false;
   }
   else if(trim(clastname.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTLASTNAME;?>');
      clastname.focus();
      return false;
   }
   else if(trim(cphone.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTPHONE;?>');
      cphone.focus();
      return false;
   }
   else if(trim(cpiva.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTPIVA;?>');
      cpiva.focus();
      return false;
   }
   else if(window.document.insertform.newpassword.value != window.document.insertform.newpasswordconfirm.value)
   {
      alert('<?php echo LANG_SETTINGS_PASSWORD_NOT_MATCH;?>');
      window.document.insertform.newpassword.focus();
      return false;
   }
   else
   {
      //firstname.value    = trim(cfirstname.value);
      //email.value   = trim(cemail.value);
      //lastname.value = trim(clastname.value);
      return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}

function isEmail(str)
{
	var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(str)) return false;
	else return true;

}
</script>
<div class="column main">
<form action="register.php" method="post" name="registerform">
	<input type="hidden" name="action" value="save"/>
	<h3><?php echo LANG_REGISTER_TITLE;?></h3>
	<table class="insert_table">
		<thead class="insert_table"><tr><td colspan="2"><?php echo LANG_REGISTER_SUBTITLE;?></td></tr></thead>
		<tbody class="insert_table">
		<tr>
		<td><?php echo LANG_SETTINGS_USER_TITLE;?></td>
		<td><select name="title">
			<option value="<?php echo LANG_TITLE_PEOPLE1?>"><?php echo LANG_TITLE_PEOPLE1?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE2?>"><?php echo LANG_TITLE_PEOPLE2?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE3?>"><?php echo LANG_TITLE_PEOPLE3?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE4?>"><?php echo LANG_TITLE_PEOPLE4?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE5?>"><?php echo LANG_TITLE_PEOPLE5?></option>
			</select></td>
	</tr>
	<tr>
		<td><?php echo LANG_FIRSTNAME;?></td>
		<td><input type="text" size="30" name="firstname"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_LASTNAME;?></td>
		<td><input type="text" size="30" name="lastname"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_PIVA;?></td>
		<td><input type="text" size="30" name="piva"/></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input type="text" size="15" name="username" id="username"/> <div id="status" style="display:inline; border: none;"></div></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" size="15" name="password"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_EMAIL;?></td>
		<td><input type="text" size="30" name="email"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_PHONE;?></td>
		<td><input type="text" size="15" name="phone"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_BIRTHDATE;?></td>
		<td><select name="day">
		<option value=""><?php echo LANG_DAY;?></option>
		<?php 
		for($i=1;$i<=31;$i++) {
			echo '<option value="'.$i.'">'.$i.'</option>';
		}		
		?>
		</select> 
		<select name="month">
			<option value=""><?php echo LANG_MONTH;?></option>
			<option value="1"><?php echo LANG_JANUARY;?></option>
			<option value="2"><?php echo LANG_FEBRUARY;?></option>
			<option value="3"><?php echo LANG_MARCH;?></option>
			<option value="4"><?php echo LANG_APRIL;?></option>
			<option value="5"><?php echo LANG_MAY;?></option>
			<option value="6"><?php echo LANG_JUNE;?></option>
			<option value="7"><?php echo LANG_JULY;?></option>
			<option value="8"><?php echo LANG_AUGUST;?></option>
			<option value="9"><?php echo LANG_SEPTEMBER;?></option>
			<option value="10"><?php echo LANG_OCTOBER;?></option>
			<option value="11"><?php echo LANG_NOVEMBER;?></option>
			<option value="12"><?php echo LANG_DECEMBER;?></option>
		</select> 
		<select name="year">
			<option value=""><?php echo LANG_YEAR;?></option>
			<?php 
				
			for($i=1920;$i<=1990;$i++) {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}		
			?>
		</select>
		</td>
	</tr>
		<tr><td colspan="2"><?php echo LANG_TERMS_TITLE;?><br/>
		<textarea style="width:100%;height:220px;" readonly="readonly">
TERMINI DI UTILIZZO

1. Applicabilit&agrave;
Le presenti Condizioni e Termini di Utilizzo regolano i rapporti contrattuali tra il cliente e SimpleNetworks ("SimpleNetworks srl"). Le Condizioni e Termini di Utilizzo si applicano a tutti gli accordi tra SimpleNetworks srl e il cliente concernenti i servizi e i prodotti offerti da SimpleNetworks srl stessa, incluso il servizio Architeka. 

 
2. Entrata in vigore, diritto di revoca, recesso
Il corrispondente accordo entra in vigore unitamente alle presenti Condizioni e Termini di Utilizzo non appena il cliente lo sottoscrive o ha confermato tramite Internet l'utilizzo dei servizi e/o dei prodotti.
SimpleNetworks srl si riserva il diritto di rescindere entro 14 giorni, senza indicazione dei motivi e senza indennizzo alcuno, qualsiasi accordo stipulato con il cliente da un proprio collaboratore o agente oppure concluso tramite internet.
Nel caso di un utilizzo dei servizi da parte del cliente contrario ai termini contrattuali o illecito o contrario ai buoni costumi, nonch&egrave; nel caso in cui il cliente abbia dato adito a reclami in ragione della qualit&agrave; scadente dei servizi erogati, SimpleNetworks srl pu&ograve; recedere immediatamente dal contratto e sospendere ogni prestazione di servizi senza una precedente comunicazione al cliente e senza indennizzo alcuno. 
Nel caso di registrazione gratuita al portale Architeka (ossia in mancanza di qualsiasi pagamento), SimpleNetworks srl può in ogni momento recedere immediatamente dal contratto e sospendere ogni prestazione di servizi senza una precedente comunicazione al cliente e senza indennizzo alcuno. 
 
3. Diritti d'accesso
SimpleNetworks srl conferisce al cliente il diritto d'accesso, mediante identificativo dell'utente e password, a quelle applicazioni di SimpleNetworks srl che di volta in volta costituiscono l'oggetto dell'accordo tra SimpleNetworks srl e il cliente.
Per SimpleNetworks srl il cliente &egrave; quella persona che utilizza l'identificativo dell'utente e la password, indipendentemente dal fatto che questa persona disponga effettivamente del diritto d'accesso. 
SimpleNetworks srl pu&ograve; in ogni momento, a proprio giudizio insindacabile, revocare l'accesso gratuito ottenuto tramite la libera registrazione (ossia in mancanza di qualsiasi pagamento).
 
4. Prezzi e condizioni di pagamento
Salvo diverso accordo esplicito, per il calcolo dei prezzi vale il listino prezzi aggiornato di volta in volta in vigore per il corrispondente prodotto. Tali listini prezzi sono richiamabili in qualsiasi momento via Internet, nel servizio corrispondente. SimpleNetworks srl si riserva di adeguare i prezzi all'evoluzione del mercato e/o dei medesimi. Salvo diverso accordo esplicito, gli adeguamenti dei prezzi si applicano anche ai contratti gi&agrave; in corso. I prezzi sono da intendersi in EURO, IVA (imposta sul valore aggiunto) esclusa.
I servizi richiedono il pagamento anticipato tramite bonifico bancario o carta di credito, con emissione della fattura elettronica immediata oppure posticipata. La consegna della fattura può avvenire anche attraverso posta elettronica oppure attraverso il portale stesso. 

 
5. Diritti immateriali
Tutti i diritti d'autore e i marchi nonch&egrave; il know how su tutte le applicazioni e le piattaforme online spettano esclusivamente a SimpleNetworks srl. Nella misura in cui l'utilizzo conforme al contratto dei servizi erogati da SimpleNetworks srl da parte del cliente richieda diritti d'uso sui diritti d'autore, sui marchi e/o sul know how di SimpleNetworks srl, quest'ultimi sono conferiti al cliente per la durata del corrispondente accordo, in modo non esclusivo e non trasferibile e soltanto nella misura ad esso necessaria. Se il cliente concorda con SimpleNetworks srl l'utilizzo di un'applicazione di terzi, questo paragrafo &egrave; applicabile per analogia anche a tale applicazione.
I diritti d'uso concessi al cliente su applicazioni e piattaforme online della SimpleNetworks srl e su applicazioni di terzi (cfr. cifra 12) sono personali e non trasferibili. 

 
6. Gestione e ulteriore sviluppo dell'applicazione
L'esercizio e la gestione dei servizi, delle piattaforme online competono a SimpleNetworks srl. Essa &egrave; autorizzata a servirsi di terzi per l'adempimento dei suoi obblighi di prestazione.
SimpleNetworks srl si prefigge d'offrire un esercizio delle applicazioni e piattaforme online il pi&ugrave; possibile esente da anomalie e interruzioni e di contenere al massimo i tempi d'interruzione necessari all'eliminazione di difetti, all'esecuzione di lavori di manutenzione e all'introduzione di nuove tecnologie e simili. L'ulteriore sviluppo tecnico &egrave; rimesso all'esclusivo apprezzamento di SimpleNetworks srl.
Le applicazioni di terzi (cfr. cifra 12) sono esercitate e gestite da quest'ultimi. L'ulteriore sviluppo tecnico &egrave; rimesso al loro apprezzamento. 

 
7. Protezione dei dati/Rete di pubblicazione
Il cliente acconsente espressamente al trasferimento diretto e/o indiretto a SimpleNetworks srl, dei dati necessari per l'utilizzo dei servizi, dei prodotti e delle applicazioni di SimpleNetworks srl, nonch&egrave; alla memorizzazione di tali dati nella(e) banca(banche) dati di SimpleNetworks srl. Il cliente acconsente inoltre espressamente al trasferimento diretto e/o indiretto dei dati necessari per l'utilizzo delle applicazioni di terzi (cfr. cifra 12), nonch&egrave; alla memorizzazione di tali dati nella(e) loro banca(banche) dati. Il cliente acconsente espressamente all'utilizzazione dei dati da parte di terzi.
SimpleNetworks srl s'impegna a rispettare le norme vigenti in materia di protezione dei dati. 

 
8. Diritti e doveri del cliente
Il cliente s'impegna a utilizzare i servizi e le applicazioni di SimpleNetworks srl e di terzi (cfr. cifra 12) nel rispetto delle leggi e del contratto ed accetta le rispettive Disposizioni d'utilizzo. 

 
9. Garanzia
SimpleNetworks srl si appoggia ad una webfarm non di propriet&agrave; come hosting del portale Architeka; per questo motivo SimpleNetworks srl non garantisce un funzionamento 24 ore su 24 del portale stesso. Trattandosi di una versione beta, il cliente accetta la possibilità del verificarsi errori, bug o malfunzionamenti che comunque verranno corretti il prima possibile da SimpleNetworks srl.
SimpleNetworks srl non &egrave; responsabile di danni (anche verso terzi) provocati da questi eventuali malfunzionamenti.
 
10. Rischio
Il cliente si assume tutti i rischi che potrebbero presentarsi a seguito di manipolazioni anomale, malfunzionamenti e/o all'uso abusivo di autorizzazioni d'accesso. 

 
11. Responsabilit&agrave;
SimpleNetworks srl risponde solo per dolo o negligenza grave. In nessun caso SimpleNetworks srl risponde per danni conseguenti e perdita di guadagno. Se SimpleNetworks srl, nonostante la massima diligenza, non pu&ograve; adempiere i suoi obblighi contrattuali per cause di forza maggiore quali, ad esempio, fenomeni naturali, eventi bellici, sciopero, restrizioni impreviste sancite da autorit&agrave;, anomalie tecniche che sono da imputare all'ambito di responsabilit&agrave; di terzi, per la durata dell'evento non sussiste alcun diritto del cliente all'adempimento del contratto.
SimpleNetworks srl non risponde per l'uso illecito di internet e per i danni derivanti al cliente ad opera di terzi, per carenze nella sicurezza e anomalie delle reti di terzi e di internet, nonch&egrave; per le interruzioni d'esercizio e le anomalie delle applicazioni e delle piattaforme online di SimpleNetworks srl e di terzi. SimpleNetworks srl non assume nessuna responsabilit&agrave; per i software di altri offerenti. 

 
12. Uso di applicazioni di terzi
Il cliente accetta, per ogni uso di applicazione di terzi integrate nelle applicazioni e/o nelle piattaforme online di SimpleNetworks srl, le corrispondenti condizioni d'uso di queste applicazioni. 

 
13. Divieto di compensazione
Il cliente non &egrave; autorizzato a compensare le sue pretese con quelle di SimpleNetworks srl. 

 
14. Divieto di cessione
Il cliente non pu&ograve; cedere a un successore in diritto i rapporti contrattuali con SimpleNetworks srl senza il consenso scritto di SimpleNetworks srl. 

15. Variazioni ed applicabilita' delle Condizioni e Termini di Utilizzo
Le modifiche e i complementi di accordi scritti, al di fuori delle Condizioni e Termini di Utilizzo, d'utilizzo necessitano per la loro validit&agrave; della forma scritta e dell'accordo di entrambi le parti contraenti. Ci&ograve; vale anche per un'eventuale rinuncia al requisito della forma scritta.
Qualora una disposizione dell'accordo si rivelasse inefficace o inattuabile, quest'ultima viene a cadere solo nella misura della sua inefficacia o inattuabilit&agrave; e deve pertanto essere sostituita con una disposizione che dal profilo economico si avvicini il pi&ugrave; possibile a quella della disposizione inefficace o inattuabile. Eventuali lacune del corrispondente accordo sono da colmare mediante regolamentazioni che si avvicinano il pi&ugrave; possibile a quanto le parti avrebbero convenuto secondo il senso e lo scopo di tale punto qualora vi si fossero soffermate al momento della stipulazione del corrispondente accordo. 

 
16. Diritto applicabile e foro competente
Le presenti Condizioni e Termini di Utilizzo sono regolate e interpretate conformemente alla legge italiana, senza applicazione delle norme di essa che regolano i conflitti di leggi. Per qualsiasi controversia, causa legale o disputa inerente o derivante dal Servizio sar&agrave; esclusivamente competente il Foro di Rimini.

Versione online: Agosto 2010
		</textarea><br/>
		<input type="checkbox" id="accetto_terms" name="accetto_terms"/> <label for="accetto_terms"><?php echo LANG_REGISTER_OK_TERMS;?></label>
		<br/><br/>
		</td></tr>
		<tr><td colspan="2"><?php echo LANG_PRIVACY_TITLE;?><br/>
		<textarea style="width:100%;height:220px;" readonly="readonly">
INFORMATIVA AI SENSI DELL'art. 13 DEL "CODICE DELLA PRIVACY" (Decreto Legislativo n. 196 del 30 giugno 2003) 

Per finalit&agrave; connesse alla fornitura dei servizi, SimpleNetworks srl con sede legale a Rimini (Italia) in via Circonvallazione Meridionale - 36 tratta i dati inviati dall'Utente, o comunque acquisiti in sede di esecuzione dei servizi. 

Il trattamento dei dati avviene con procedure idonee a tutelare la riservatezza dell'Utente e consiste nella loro raccolta, registrazione, organizzazione, conservazione, elaborazione, modificazione, selezione, estrazione, raffronto, utilizzo, interconnessione, blocco, comunicazione, diffusione, cancellazione, distruzione degli stessi comprese la combinazione di due o pi&ugrave; delle attivit&agrave; suddette. 

Ai sensi e per gli effetti dell'art. 13 Codice della Privacy si rende noto quanto segue:

   1. I dati personali da Lei volontariamente forniti all'atto di compilazione del Modulo di Registrazione per l'Accesso al Servizio saranno oggetto di trattamento, che avr&agrave; luogo prevalentemente con modalit&agrave; automatizzate ed informatizzate, sempre nel rispetto delle regole di riservatezza e di sicurezza previste dalla legge. I dati saranno conservati per i termini di legge presso SimpleNetworks srl e trattati da parte di dipendenti e/o professionisti da questa incaricati, i quali svolgono le suddette attivit&agrave; sotto la sua diretta supervisione e responsabilit&agrave;. A tal fine, i dati comunicati dall'Utente potranno essere trasmessi a soggetti esterni che svolgono funzioni strettamente connesse e strumentali all'operativit&agrave; del Servizio.

      Il trattamento dei dati ha finalit&agrave; connesse o strumentali al Servizio fornito da SimpleNetworks srl, e precisamente:
          * raccogliere dati ed informazioni in via generale e particolare sugli orientamenti e le preferenze dell'Utente;
          * inviare informazioni ed offerte commerciali, anche di terzi;
          * inviare materiale pubblicitario e informativo;
          * effettuare comunicazioni commerciali, anche interattive;
          * compiere attivit&agrave; dirette di vendita o di collocamento di prodotti o servizi;
          * elaborare studi e ricerche statistiche su vendite, clienti e altre informazioni, attivit&agrave; di marketing ed eventualmente comunicare le stesse a terze parti;
          * cedere a terzi i dati raccolti ed elaborati a fini commerciali anche per la vendita o tentata vendita, ovvero per tutte quelle finalit&agrave; a carattere commerciale e/o statistico lecite e gi&agrave; parzialmente indicate nei superiori punti;
          * 2.        I dati personali potranno essere comunicati da SimpleNetworks srl alle categorie di soggetti di seguito esemplificate, per tutte le finalit&agrave; indicate in precedenza al punto 1 della presente informativa:
          * altre Societ&agrave; di terzi soggetti, incaricati dell'esecuzione di attivit&agrave; direttamente connesse e strumentali all'erogazione del Servizio o con i quali SimpleNetworks srl abbia stipulato accordi commerciali funzionali alla diffusione ed allo sviluppo del Servizio, dei quali &egrave; disponibile una lista dettagliata su Sua espressa richiesta; e/o
          * altre societ&agrave; che offrono beni e/o servizi appartenenti a categorie merceologiche pubblicizzate attraverso la rete Internet, con le quali SimpleNetworks abbia stipulato accordi commerciali.
          * I suoi dati personali potranno essere oggetto di trattamento, per le finalit&agrave; di cui al punto 1 della presente informativa, anche attraverso le seguenti modalit&agrave;: telefax, telefono, anche senza assistenza di operatore, posta elettronica, SMS ed altri sistemi informatici e/o automatizzati di comunicazione.
          * I suoi dati personali potranno essere trasferiti all'estero.
          * In relazione al suddetto trattamento di dati personali, Lei potr&agrave; esercitare tutti i diritti previsti dal Codice della Privacy, incluso il diritto di negare o ritirare il consenso in qualsiasi momento e per qualsiasi scopo, nonch&egrave; il diritto di correggere, completare o rendere indisponibili i propri dati personali. In particolare, qualora Lei inoltri a SimpleNetworks srl la richiesta di cancellazione dei suoi dati personali SimpleNetworks srl provveder&agrave; immediatamente a tale cancellazione; ci&ograve; comporter&agrave; l'immediata cessazione del Servizio.

            Ai sensi dell'articolo 7 del D. Lgs. N. 196/2003, potr&agrave; esercitare i seguenti diritti:
               1. ottenere la conferma dell'esistenza dei dati personali che la riguardano, anche se non ancora registrati e la loro comunicazione in forma intelligibile;
               2. ottenere l'indicazione delle origini dei dati personali, delle finalit&agrave; e modalit&agrave; del trattamento, della logica applicata in caso di trattamento effettuato con l'ausilio di strumenti elettronici, degli estremi identificativi del titolare e dei responsabili del trattamento e del rappresentante designato ai sensi dell'art. 5, co.2 del medesimo D. Lgs., dei soggetti o delle categorie di soggetti ai quali i dati personali possono essere comunicati o che possono venirne a conoscenza in qualit&agrave; di rappresentante designato nel territorio dello Stato, di responsabili o incaricati;
               3. ottenere l'aggiornamento, la rettificazione, ovvero, quando vi ha interesse, l'integrazione dei dati;
               4. ottenere la cancellazione, la trasformazione, in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non &egrave; necessaria la conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;
               5. ottenere l'attestazione che l'aggiornamento, la rettificazione, l'integrazione, la cancellazione, la trasformazione in forma anonima o il blocco sono stati portati a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai quali i dati sono stati comunicati o diffusi, eccettuato il caso in cui tale adempimento si rivela impossibile o comporta un impiego di mezzi manifestamente sproporzionato rispetto al diritto tutelato;
               6. opporsi in tutto o in parte, per motivi legittimi, al trattamento dei dati personali che la riguardano, ancorch&egrave; pertinenti allo scopo della raccolta;
               7. opporsi in tutto o in parte, al trattamento dei dati che la riguardano a fini di invio di materiale pubblicitario o di vendita diretta o per il compimento di ricerche di mercato o di comunicazione commerciale.


          * L'acquisizione dei dati personali ha natura facoltativa. Tuttavia, il mancato conferimento, anche parziale, dei dati personali richiesti per la compilazione del Modulo di Registrazione per l'Accesso al Servizio determiner&agrave; l'impossibilit&agrave; per SimpleNetworks srl di procedere all'erogazione del Servizio stesso.
          * SimpleNetworks srl si impegna a non utilizzare i dati segnalati come inesatti.
          * SimpleNetworks srl con sede legale a Rimini in via Circonvallazione Meridionale - 36 &egrave; Titolare e Responsabile del trattamento dei dati. Il responsabile del trattamento dei dati &egrave; il dott. Calisesi Nicola


Per ogni comunicazione e/o richiesta in relazione al trattamento dei suoi dati personali, La preghiamo di scrivere a info@simplenetworks.it
		</textarea><br/>
		<input type="checkbox" id="accetto_privacy" name="accetto_privacy"/> <label for="accetto_privacy"><?php echo LANG_REGISTER_OK_PRIVACY; ?></label>
		<br/><br/>
		</td></tr>
		<tr><td><?php echo LANG_FORGOTTEN_PWD_CAPTCHA;?></td><td> <input type="text" name="code"/> </td></tr>
		<tr><td colspan="2" align="center"><img src="register.php?captcha=1"/></td></tr>
		</tbody>
		<tfoot class="insert_table">
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo LANG_SIGNUP;?>" onClick="return checkForm();"/></td>
		</tr>
	    </tfoot>
	</table>
</form>
</div>