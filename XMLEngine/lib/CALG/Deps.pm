package CALG::Deps;

use warnings;
use strict;

#our $VERSION  '0.01';

use Carp;

use FindBin qw($Bin);
use Socket;
use POE::Session;
use POE qw(
        Wheel::SocketFactory 
        Wheel::ReadWrite
		Component::IKC::Server
		Component::IKC::ClientLite
		Component::IKC::Specifier
		Component::Client::Telnet
        );

use XML::LibXML;
use Config::Any::INI;
use Config::Any::XML;
use Template::Simple;
1;
