{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "svanderburg/php-sbdata" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sbdata-c523df3ac14f8d8eab4a20cf89f5d9d006a02312";
        url = "https://github.com/svanderburg/php-sbdata.git";
        rev = "c523df3ac14f8d8eab4a20cf89f5d9d006a02312";
        sha256 = "140fsvhdyzim2l5dn7xxycqfpxgi9aar6xmk80aa4ss1n0rjsrf1";
      };
    };
    "svanderburg/php-sblayout" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sblayout-f0a84a0ae4fdd090ded92dba4261104d6145bdc3";
        url = "https://github.com/svanderburg/php-sblayout.git";
        rev = "f0a84a0ae4fdd090ded92dba4261104d6145bdc3";
        sha256 = "0fnas5lfs60kmdq6vm4dycp9498l5zy6bfbfhnqmwgynvx4r2dmb";
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
