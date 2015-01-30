open (SA,"valueforaspecialstation313030337.csv");
open (OX, ">sample313030337.xml");

while (<SA>)
{
$line = $_;
@val = split (",",$line);
$id = $val[0];
$key = $id;
$key =~ s/\@.*//;
$skid = $val[1];
$snm = $val[2];
$pval = $val[3];
$lbl = $val[4];
$status = $val[5];
chomp($status);

$outstring .= "<feature id=\"$id\" key=\"$key\" status=\"$status\">\n\t<primary_value>$pval</primary_value>\n\t<label>$lbl</label>\n</feature>\n"

}
#Example output
# <feature id="01@123456789-DN" key="01">
		# <primary_value>123456789</primary_value>
		# <label>Craig Martin</label>
# </feature>
$ph = $id;
if ($ph =~ /[^\@]*\@([^\-]*)\-/) {$ph=$1;}
$prestring = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<Configuration xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"configuration_schema2.xsd\">\n<Station id=\"$ph\"  status=\"1\">\n";

print OX $prestring.$outstring . "</Station>\n</Configuration>";