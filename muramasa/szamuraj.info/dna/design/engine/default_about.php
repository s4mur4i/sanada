<CENTER>
<H1><?=SOFTWARE_LONGNAME?> (<?=SOFTWARE_SHORTNAME?>) <?=SOFTWARE_VERSION?> "<?=SOFTWARE_EDITION?>"</H1>
<P><A<?=$user->LIN==1?" target='_blank'":""?> href='https://hippy.csoma.elte.hu/projects/dna/trac.cgi'>Projekt honlap</A></P>
<? require_once("design/engine/default_result.php"); ?>
<TABLE border=0 cellspacing=0 cellpadding=3><TR><TD>
<H2>Definíció</H2>
<P>Számítógép hálózati nyilvántartó és adatszolgáltató program.</P>
<H2>Fejlesztők</H2>
<UL>
<LI>Darabos Edvárd Konrád (nil, 2003-) Support: nil@hippy.csoma.elte.hu</LI>
<LI>Kancsal Zoltán (turdus, 2003-2005)</LI>
</UL>
<P>
A program elkészítése során egyetlen pixel sem sérült meg.<BR>
A program elkészítéséhez csak szabad szoftvereket használtunk.<BR>
<A href='http://www.debian.org/'>Debian</A>
<A href='http://httpd.apache.org/'>Apache</A>
<A href='http://www.php.net/'>PHP</A>
<A href='http://www.mysql.org/'>MySQL</A>
<A href='http://subversion.tigris.org/'>SVN</A>
<A href='http://trac.edgewall.org/'>Trac</A>
<BR>
</P>
</TD></TR></TABLE>
<BR>
<? if($user->LIN==1){ ?>
[ <A href='index.php?mode=home'>OK</A> ]<BR>
<? } else { ?>
[ <A href='index.php?mode=login'>OK</A> ]<BR>
<? } ?>
<BR>
<H2>Changelog</H2>
<TABLE cellspacing=0 cellpadding=5 style='border: 1px solid #888888;'>
<TR><TD>
<?
	readfile("include/changelog.html");
?>
</TD></TR>
</TABLE>
<BR>
</CENTER>