package Foursol::Transaction;

use strict;
use warnings;

sub new {
	my $class = shift;
	my %p;
	my $time = time();
	$p{id} = $time;
	my $self = bless(\%p, $class);
	return $self; 
}

sub id {
	my $self = shift;
	return $self->{id};
}

sub alg_session_id {
	my $self = shift;
	return $self->{alg_session_id} unless @_;
	$self->{alg_session_id} = shift;
}

sub data {
	my $self = shift;
	return $self->{data} unless @_;
	$self->{data} = shift;
}


1;
