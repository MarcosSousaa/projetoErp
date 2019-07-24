<style>
/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xx  CSS Table Gallery            xx          
xx  Author: Mauricio Samy Silva  xx
xx  URL: http://www.maujor.com/  xx
xx  Country: Brazil              xx
xx  Date: 2005-09-02             xx
xx  xxxxxxxxxxxxxxxxxxxxxxxxxxxxx*/
.planos .planos {
	background: #c2cadd url(bg-table.jpg) 0 0 repeat-y;
	border-collapse:collapse;
	margin-top:3px; 
	border:1px solid #946f00;
	padding: 30px 10px 5px; 
}

/* \*/
* html .planos {	
	border:1px solid #09c;
	border-top:3px dashed #09c;
}	
/* */	

.planos tr * {font:1.0em Arial, Helvetica, sans-serif;}

.planos tr td, table tr th  {border:1px solid #09c;}

.planos tr th + td + td + td + td {border-right:3px solid #946f00;}

.planos tr td {color:#946f00;}

.planos tr *:hover, tbody tr.odd td:hover {background: transparent url(alphaover.gif);}

.planos tfoot tr *:hover {background: none;}

.planos thead th[scope]:hover {
	background:#d7e2f6 url(none); 
	color:#000; 
	border-left:2px solid #ccc;
	border-right:2px solid #999;
	border-top:2px solid #ccc;
	border-bottom:2px solid #999;
}

.planos caption { 
	border: solid #946f00;
	border-width: 1px 3px 3px 1px;
	background: #ede6ca url(ns.gif) center repeat-x;
	font: bold 1.0em/1.8em Arial, Helvetica, sans-serif;
	color:#946f00;
	text-transform:uppercase;
}

/* \*/
* html .planos caption {	
	border:1px solid #09c;
	}	
/* */	

.planos caption:hover:before { 
	background:transparent url(alpha3.gif); 
	font-size:0.9em; 
	padding:2px 3.9em; 
	margin-right:10px;
	color:#fff; 
	content: "     *** I love CSS ***";
	text-transform:none;
}
.planos caption:hover:after { 
	background:transparent url(alpha3.gif); 
	font-size:0.9em; 
	padding:2px 1.5em; 
	margin-left:10px;
	color:#fff; 
	content: "*** Stylizing data tables ***";
	text-transform:none;
}

.planos thead {
	background:transparent url(alpha.gif);
	border-right :3px solid #946f00; 
	}

.planos tbody th {background:transparent url(alpha2.gif);}

.planos tbody tr.odd td {background:transparent url(alpha1.gif);}

.planos tbody td {background:transparent url(alpha1.gif);}

.planos thead tr th {
	border-left:2px solid #999;
	border-right :2px solid #ccc;
	border-top:2px solid #ccc;
	border-bottom:2px solid #999;
	padding :5px; 
	font:bold 1.0em Arial, Helvetica, sans-serif;
	color:#fff;
	}

.planos tfoot {
	border:3px solid #946f00; 
	border-width:0 3px 3px 0;
	}

.planos tfoot tr th {
	color:#fff;
	text-align : left;
	}

.planos tfoot tr td {
	color:#fff;
	text-align:right;
}

.planos tfoot tr * {
	padding: 8px 10px; 
	text-transform:uppercase;  
	border-width:1px 0 0;
	}

.planostbody tr * {padding: 5px;}

 .planos tbody th a {
	color :#fff; 
	padding:1.0em 3.0em 0 0;
	text-decoration:none;
	}

.planos tbody th a:hover {
	background:none;
	color:#f00;
	}

.planos tbody td a {
	padding: 1px;
	text-decoration: none;
	}

.planos tbody td a:hover {
	background:none;
	color:#f00;
	}
</style>
<table width="500" border="1" cellspacing="0" cellpadding="0" align="center" class="planos">
	<thead>
    	<tr>
	    	<td>
	    		<strong>PLANOS</strong>
	    	</td>
	    	<td >
	    		<strong>FULL </strong>
	    		<p>R$39,90</p>
	    	</td>
	    	<td>
	    		<strong>PRO</strong>
	    		<p>29,90</p>
	    	</td>
	    	<td>
	    		<strong>LIGHT</strong>
	    		<p>19,90</p>
	    	</td>
    	</tr>
  	</thead>
  	<tr>
	    <td>Limite de Notas Mensais</td>
	    <td>Ilimitado</td>
	    <td>50</td>
	    <td>20</td>
  	</tr>
  	<tr>
	    <td>Relatório de Notas Emitidas e Canceladas</td>
	    <td ><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/erro.png" border="0"></td>
  	</tr>
  	<tr>
	    <td>Suporte Online</td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/accept.png" border="0"></td>
  	</tr>
  	<tr>
	    <td>Backup das NFes </td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/erro.png" border="0"></td>
  	</tr>
  	<tr>
	    <td>Aceita certificado A1</td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/accept.png" border="0"></td>
  	</tr>
  	<tr>
	    <td>Aceita Certificado A3</td>
	    <td><img src="imgs/erro.png" border="0"></td>
	    <td><img src="imgs/erro.png" border="0"></td>
	    <td><img src="imgs/erro.png" border="0"></td>
  	</tr>
  	<tr>
	    <td>Compacta e envia xmls por período</td>
	    <td><img src="imgs/accept.png" border="0"></td>
	    <td><img src="imgs/erro.png" border="0"></td>
	    <td><img src="imgs/erro.png" border="0"></td>
  	</tr>
</table>
