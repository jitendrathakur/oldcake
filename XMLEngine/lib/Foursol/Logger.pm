package Foursol::Logger;

use strict;
use warnings;
use Carp;

use Sub::Exporter -setup => { exports => [ qw( log_debug log_warning log_error ) ] };
use Sys::Syslog qw(:DEFAULT setlogsock);

sub log_debug {
        my ($msg) = "DEBUG : ";
        $msg .= $_[0];
	my $priority = 'debug';
#        return 0 unless ($priority =~ /info|error|debug|activity/);

        setlogsock('unix');
        # $programname is assumed to be a global.  Also log the PID
        # and to CONSole if there's a problem.  Use facility 'user'.
        openlog($0, 'pid,cons', 'local0');
        syslog($priority, $msg);
        closelog();
}

sub log_warning {
        my ($msg) = "WARNING : ";
        $msg .= $_[0];
	my $priority = 'warning';
#        return 0 unless ($priority =~ /info|error|debug|activity/);

        setlogsock('unix');
        # $programname is assumed to be a global.  Also log the PID
        # and to CONSole if there's a problem.  Use facility 'user'.
        openlog($0, 'pid,cons', 'local0');
        syslog($priority, $msg);
        closelog();
}
sub log_error {
        my ($msg) = "ERROR : ";
        $msg .= $_[0];
	my $priority = 'err';
#        return 0 unless ($priority =~ /info|error|debug|activity/);

        setlogsock('unix');
        # $programname is assumed to be a global.  Also log the PID
        # and to CONSole if there's a problem.  Use facility 'user'.
        openlog($0, 'pid,cons', 'local0');
        syslog($priority, $msg);
        closelog();
}

1;

