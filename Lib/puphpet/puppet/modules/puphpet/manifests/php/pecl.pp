/*
 * This "translates" PECL package names into system-specific names.
 * For example, APCu does not install correctly on CentOS via PECL,
 * but there is a system package for it that works well. Use that
 * instead of the PECL package.
 */

define puphpet::php::pecl (
  $service_autorestart
){

  $pecl = $::osfamily ? {
    'Debian' => {
      #
    },
    'Redhat' => {
      #
    }
  }

  $pecl_beta = $::osfamily ? {
    'Debian' => {
      'zendopcache' => $::operatingsystem ? {
        'debian' => false,
        'ubuntu' => 'ZendOpcache',
      },
    },
    'Redhat' => {
      #
    }
  }

  $package = $::osfamily ? {
    'Debian' => {
      'apc'         => $::operatingsystem ? {
        'debian' => 'php5-apc',
        'ubuntu' => 'php5-apcu',
      },
      'apcu'        => 'php5-apcu',
      'imagick'     => 'php5-imagick',
      'memcache'    => 'php5-memcache',
      'memcached'   => 'php5-memcached',
      'mongo'       => 'php5-mongo',
      'zendopcache' => 'php5-zendopcache',
    },
    'Redhat' => {
      'apc'         => 'php-pecl-apcu',
      'apcu'        => 'php-pecl-apcu',
      'imagick'     => 'php-pecl-imagick',
      'memcache'    => 'php-pecl-memcache',
      'memcached'   => 'php-pecl-memcached',
      'mongo'       => 'php-pecl-mongo',
      'zendopcache' => 'php-pecl-zendopcache',
    }
  }

  $downcase_name = downcase($name)

  if has_key($pecl, $downcase_name) {
    $pecl_name       = $pecl[$downcase_name]
    $package_name    = false
    $preferred_state = 'stable'
  }
  elsif has_key($pecl_beta, $downcase_name) and $pecl_beta[$downcase_name] {
    $pecl_name       = $pecl_beta[$downcase_name]
    $package_name    = false
    $preferred_state = 'beta'
  }
  elsif has_key($package, $downcase_name) {
    $pecl_name    = false
    $package_name = $package[$downcase_name]
  }
  else {
    $pecl_name    = $name
    $package_name = false
  }

  if $pecl_name and ! defined(Php::Pecl::Module[$pecl_name]) {
    php::pecl::module { $pecl_name:
      use_package         => false,
      preferred_state     => $preferred_state,
      service_autorestart => $service_autorestart,
    }
  }
  elsif $package_name and ! defined(Package[$package_name]) {
    package { $package_name:
      ensure  => present,
      require => Class['Php::Devel'],
    }
  }

}
