{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "svanderburg/php-sbdata" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sbdata-434133b7b1341885bd064ba84ee48732abeb9b3d";
        url = "https://github.com/svanderburg/php-sbdata.git";
        rev = "434133b7b1341885bd064ba84ee48732abeb9b3d";
        sha256 = "1m753gy4dicajxhrxvvkxbb6pchdppbkwvwbf4z9dzlxnwxsij00";
      };
    };
    "svanderburg/php-sblayout" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sblayout-126b3eb89e1e5a90675c26746be560c712300698";
        url = "https://github.com/svanderburg/php-sblayout.git";
        rev = "126b3eb89e1e5a90675c26746be560c712300698";
        sha256 = "0mgy3fdfm729mjgipbpfr2w8j6fm1ylqyglf350aivq57ccyhg3h";
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
