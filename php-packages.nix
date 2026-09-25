{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "svanderburg/php-sbdata" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sbdata-e348b06cba899322d1371384c532413890596f91";
        url = "https://github.com/svanderburg/php-sbdata.git";
        rev = "e348b06cba899322d1371384c532413890596f91";
        sha256 = "1d63dyp7mbdps1sp0wbkd0acs00id6cfayv69bckvhdwkhl9vsi5";
      };
    };
    "svanderburg/php-sblayout" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sblayout-7ee4794bedd8d1ea10fc90a9b561978186a7a6b7";
        url = "https://github.com/svanderburg/php-sblayout.git";
        rev = "7ee4794bedd8d1ea10fc90a9b561978186a7a6b7";
        sha256 = "04fmndssrxnahm6gz09qf10nwxw4kcpnfr09m4z0g9l3kh4dwxyh";
      };
    };
  };
  devPackages = {};
in
composerEnv.buildPackage {
  inherit packages devPackages noDev;
  name = "svanderburg-php-sbcrud";
  src = composerEnv.filterSrc ./.;
  executable = false;
  symlinkDependencies = false;
  meta = {
    license = "Apache-2.0";
  };
}
