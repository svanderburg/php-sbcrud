{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "svanderburg/php-sbdata" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sbdata-ee777698c697ddee23e060db9621487022f76c11";
        url = "https://github.com/svanderburg/php-sbdata.git";
        rev = "ee777698c697ddee23e060db9621487022f76c11";
        sha256 = "0l878g61d8kqmp3inwglxv2c50c6r0dmf4gi0p2n5ww59m3f29vx";
      };
    };
    "svanderburg/php-sblayout" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sblayout-1cf019759fed392d2a75e2caf5e5a929d7668267";
        url = "https://github.com/svanderburg/php-sblayout.git";
        rev = "1cf019759fed392d2a75e2caf5e5a929d7668267";
        sha256 = "0mr5v8jkkpksn6cvsswglyynkmdgqmc8gff2hi5a01i8wp5k60sx";
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
