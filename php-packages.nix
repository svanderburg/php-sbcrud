{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "svanderburg/php-sbdata" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sbdata-cbe47d7b902779decd54399dac570beb1e75373a";
        url = "https://github.com/svanderburg/php-sbdata.git";
        rev = "cbe47d7b902779decd54399dac570beb1e75373a";
        sha256 = "09kk38vccjwp7bdz1qh7czgf6ik6rxhzhv57x4ipz44jism9ly21";
      };
    };
    "svanderburg/php-sblayout" = {
      targetDir = "";
      src = fetchgit {
        name = "svanderburg-php-sblayout-a3b631fdc87185cb70a14b681e81d50cacd293ac";
        url = "https://github.com/svanderburg/php-sblayout.git";
        rev = "a3b631fdc87185cb70a14b681e81d50cacd293ac";
        sha256 = "0d8aicpdnmzb66pbfishigbbakhrl55hi9vq42fmfm6ihmbabywa";
      };
    };
  };
  devPackages = {
    "cilex/cilex" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "cilex-cilex-7acd965a609a56d0345e8b6071c261fbdb926cb5";
        src = fetchurl {
          url = "https://api.github.com/repos/Cilex/Cilex/zipball/7acd965a609a56d0345e8b6071c261fbdb926cb5";
          sha256 = "0hi8xfwkj7bj15mpaqxj06bngz4gk2idhkc9yxxr5k4x72swvhzp";
        };
      };
    };
    "cilex/console-service-provider" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "cilex-console-service-provider-25ee3d1875243d38e1a3448ff94bdf944f70d24e";
        src = fetchurl {
          url = "https://api.github.com/repos/Cilex/console-service-provider/zipball/25ee3d1875243d38e1a3448ff94bdf944f70d24e";
          sha256 = "1g9zgx1hplkbhhqsci5l4m9j7mi6w6j6b32bg0sn3b9q3510damg";
        };
      };
    };
    "container-interop/container-interop" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "container-interop-container-interop-79cbf1341c22ec75643d841642dd5d6acd83bdb8";
        src = fetchurl {
          url = "https://api.github.com/repos/container-interop/container-interop/zipball/79cbf1341c22ec75643d841642dd5d6acd83bdb8";
          sha256 = "1pxm461g5flcq50yabr01nw8w17n3g7klpman9ps3im4z0604m52";
        };
      };
    };
    "doctrine/annotations" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-annotations-5b668aef16090008790395c02c893b1ba13f7e08";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/annotations/zipball/5b668aef16090008790395c02c893b1ba13f7e08";
          sha256 = "129dixpipqfi55yq1rcp7dwj1yl1w70i462rs16ma4bn5vzxqz5s";
        };
      };
    };
    "doctrine/instantiator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-instantiator-d56bf6102915de5702778fe20f2de3b2fe570b5b";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/instantiator/zipball/d56bf6102915de5702778fe20f2de3b2fe570b5b";
          sha256 = "04rihgfjv8alvvb92bnb5qpz8fvqvjwfrawcjw34pfnfx4jflcwh";
        };
      };
    };
    "doctrine/lexer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-lexer-9c50f840f257bbb941e6f4a0e94ccf5db5c3f76c";
        src = fetchurl {
          url = "https://api.github.com/repos/doctrine/lexer/zipball/9c50f840f257bbb941e6f4a0e94ccf5db5c3f76c";
          sha256 = "0cczszzlzws2fbc66npl93x8ayqv4bqls4rpkxg1zylcvf8f3cw8";
        };
      };
    };
    "erusev/parsedown" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "erusev-parsedown-cb17b6477dfff935958ba01325f2e8a2bfa6dab3";
        src = fetchurl {
          url = "https://api.github.com/repos/erusev/parsedown/zipball/cb17b6477dfff935958ba01325f2e8a2bfa6dab3";
          sha256 = "1iil9v8g03m5vpxxg3a5qb2sxd1cs5c4p5i0k00cqjnjsxfrazxd";
        };
      };
    };
    "jms/metadata" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "jms-metadata-e5854ab1aa643623dc64adde718a8eec32b957a8";
        src = fetchurl {
          url = "https://api.github.com/repos/schmittjoh/metadata/zipball/e5854ab1aa643623dc64adde718a8eec32b957a8";
          sha256 = "0rzdbhy2bpzm4d8ai1d9ybv26ri6n5y1x9wdrr0r40hh4ngypffy";
        };
      };
    };
    "jms/parser-lib" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "jms-parser-lib-c509473bc1b4866415627af0e1c6cc8ac97fa51d";
        src = fetchurl {
          url = "https://api.github.com/repos/schmittjoh/parser-lib/zipball/c509473bc1b4866415627af0e1c6cc8ac97fa51d";
          sha256 = "1jkgihdxc28vklqzp7zd6wvi6q9dsym1q8cig9x6rm0ws51fns85";
        };
      };
    };
    "jms/serializer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "jms-serializer-4fad8bbbe76e05de3b79ffa3db027058ed3813ff";
        src = fetchurl {
          url = "https://api.github.com/repos/schmittjoh/serializer/zipball/4fad8bbbe76e05de3b79ffa3db027058ed3813ff";
          sha256 = "1mcxqdqjg021rsii90fkmii2brk9ahn4yrlbnyr9839nlv9w5cgb";
        };
      };
    };
    "monolog/monolog" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "monolog-monolog-c6b00f05152ae2c9b04a448f99c7590beb6042f5";
        src = fetchurl {
          url = "https://api.github.com/repos/Seldaek/monolog/zipball/c6b00f05152ae2c9b04a448f99c7590beb6042f5";
          sha256 = "02hr0z3rshvk7hiva7ag3rblr1wymm6s7s9i2yy5bai8f2qwjvdf";
        };
      };
    };
    "nikic/php-parser" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "nikic-php-parser-f78af2c9c86107aa1a34cd1dbb5bbe9eeb0d9f51";
        src = fetchurl {
          url = "https://api.github.com/repos/nikic/PHP-Parser/zipball/f78af2c9c86107aa1a34cd1dbb5bbe9eeb0d9f51";
          sha256 = "008iv40q92cldbfqs5bc9s11i0fpycjafv7s4wk4y6h5wrbf34qk";
        };
      };
    };
    "padraic/humbug_get_contents" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "padraic-humbug_get_contents-66797199019d0cb4529cb8d29c6f0b4c5085b53a";
        src = fetchurl {
          url = "https://api.github.com/repos/humbug/file_get_contents/zipball/66797199019d0cb4529cb8d29c6f0b4c5085b53a";
          sha256 = "03n1mq7pfjcqip4v8249zksfkyzbywmb829s117yhpjib6nc4plf";
        };
      };
    };
    "padraic/phar-updater" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "padraic-phar-updater-d01d3b8f26e541ac9b9eeba1e18d005d852f7ff1";
        src = fetchurl {
          url = "https://api.github.com/repos/humbug/phar-updater/zipball/d01d3b8f26e541ac9b9eeba1e18d005d852f7ff1";
          sha256 = "0lwrb0g55k09qqpbnjr0i2flka3pj1qa5w7k8bxh77ypx7qadg4f";
        };
      };
    };
    "phpcollection/phpcollection" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpcollection-phpcollection-f2bcff45c0da7c27991bbc1f90f47c4b7fb434a6";
        src = fetchurl {
          url = "https://api.github.com/repos/schmittjoh/php-collection/zipball/f2bcff45c0da7c27991bbc1f90f47c4b7fb434a6";
          sha256 = "0bfbg7bs7q3wmyl3kp3vqshcj0pklj14z1vlxk4ymxrjzxwmb8my";
        };
      };
    };
    "phpdocumentor/fileset" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-fileset-bfa78d8fa9763dfce6d0e5d3730c1d8ab25d34b0";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/Fileset/zipball/bfa78d8fa9763dfce6d0e5d3730c1d8ab25d34b0";
          sha256 = "0ncvq8zfnr3azzpw0navm2lk9w0dskk7mar2m4immzxyip00gp89";
        };
      };
    };
    "phpdocumentor/graphviz" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-graphviz-a906a90a9f230535f25ea31caf81b2323956283f";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/GraphViz/zipball/a906a90a9f230535f25ea31caf81b2323956283f";
          sha256 = "06y7pha2nrki27k2jdpb4l1px5ngpwlwrmgg6lcxlzp4brf1q7ds";
        };
      };
    };
    "phpdocumentor/phpdocumentor" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-phpdocumentor-2e4f981a55ebe6f5db592d7da892d13d5b3c7816";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/phpDocumentor/zipball/2e4f981a55ebe6f5db592d7da892d13d5b3c7816";
          sha256 = "0553jx5n6pr6a4qrqz0y007saxd61q4z6r0dcwaw71r7q4fw76wa";
        };
      };
    };
    "phpdocumentor/reflection" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-reflection-793bfd92d9a0fc96ae9608fb3e947c3f59fb3a0d";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/Reflection/zipball/793bfd92d9a0fc96ae9608fb3e947c3f59fb3a0d";
          sha256 = "1k2hbcjkiyyb8yzw9682i4i0bnrdzfapj6qhh4idn2d80bqzgkir";
        };
      };
    };
    "phpdocumentor/reflection-docblock" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-reflection-docblock-e6a969a640b00d8daa3c66518b0405fb41ae0c4b";
        src = fetchurl {
          url = "https://api.github.com/repos/phpDocumentor/ReflectionDocBlock/zipball/e6a969a640b00d8daa3c66518b0405fb41ae0c4b";
          sha256 = "0hgrmgcdi9qadwsjcplg6lfjjwdjfajd2vm97bd0jkh0ykrxqghs";
        };
      };
    };
    "phpoption/phpoption" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpoption-phpoption-eab7a0df01fe2344d172bff4cd6dbd3f8b84ad15";
        src = fetchurl {
          url = "https://api.github.com/repos/schmittjoh/php-option/zipball/eab7a0df01fe2344d172bff4cd6dbd3f8b84ad15";
          sha256 = "1lk50y8jj2mzbwc2mxfm2xdasxf4axya72nv8wfc1vyz9y5ys3li";
        };
      };
    };
    "pimple/pimple" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "pimple-pimple-2019c145fe393923f3441b23f29bbdfaa5c58c4d";
        src = fetchurl {
          url = "https://api.github.com/repos/silexphp/Pimple/zipball/2019c145fe393923f3441b23f29bbdfaa5c58c4d";
          sha256 = "17rnqcfmdr7lfvqprcnn3cbldj37gi9d7g8rjz6lzr813cj9q826";
        };
      };
    };
    "psr/cache" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-cache-aa5030cfa5405eccfdcb1083ce040c2cb8d253bf";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/cache/zipball/aa5030cfa5405eccfdcb1083ce040c2cb8d253bf";
          sha256 = "07rnyjwb445sfj30v5ny3gfsgc1m7j7cyvwjgs2cm9slns1k1ml8";
        };
      };
    };
    "psr/container" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-container-513e0666f7216c7459170d56df27dfcefe1689ea";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/container/zipball/513e0666f7216c7459170d56df27dfcefe1689ea";
          sha256 = "00yvj3b5ls2l1d0sk38g065raw837rw65dx1sicggjnkr85vmfzz";
        };
      };
    };
    "psr/log" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "psr-log-d49695b909c3b7628b6289db5479a1c204601f11";
        src = fetchurl {
          url = "https://api.github.com/repos/php-fig/log/zipball/d49695b909c3b7628b6289db5479a1c204601f11";
          sha256 = "0sb0mq30dvmzdgsnqvw3xh4fb4bqjncx72kf8n622f94dd48amln";
        };
      };
    };
    "symfony/config" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-config-7dd5f5040dc04c118d057fb5886563963eb70011";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/config/zipball/7dd5f5040dc04c118d057fb5886563963eb70011";
          sha256 = "09cmr151xyl76il2vdgy92vpmhxg5wpmi8jbxxvxlphh6bqk6l3h";
        };
      };
    };
    "symfony/console" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-console-cbcf4b5e233af15cd2bbd50dee1ccc9b7927dc12";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/console/zipball/cbcf4b5e233af15cd2bbd50dee1ccc9b7927dc12";
          sha256 = "1bcjfhpccs4r5988rqmfdi1xx0pcvc9yh5hba11ba46sql1hwxr3";
        };
      };
    };
    "symfony/debug" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-debug-697c527acd9ea1b2d3efac34d9806bf255278b0a";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/debug/zipball/697c527acd9ea1b2d3efac34d9806bf255278b0a";
          sha256 = "00d4kbzswrymand3rrhyc173fs26x55d38bvs17d5y6bk5glr6q1";
        };
      };
    };
    "symfony/event-dispatcher" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-event-dispatcher-a77e974a5fecb4398833b0709210e3d5e334ffb0";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/event-dispatcher/zipball/a77e974a5fecb4398833b0709210e3d5e334ffb0";
          sha256 = "1v0hv5ghbrjl3hhvrfhhks1adwms05ybm4yvffwyqqcm77yvv8cg";
        };
      };
    };
    "symfony/filesystem" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-filesystem-b2da5009d9bacbd91d83486aa1f44c793a8c380d";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/filesystem/zipball/b2da5009d9bacbd91d83486aa1f44c793a8c380d";
          sha256 = "1ijgs2yj900q26f1dr81nbb1s3hjmhzh4pap13145r71acjh7q37";
        };
      };
    };
    "symfony/finder" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-finder-1444eac52273e345d9b95129bf914639305a9ba4";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/finder/zipball/1444eac52273e345d9b95129bf914639305a9ba4";
          sha256 = "0vnc79kvnk6n5jcd3kfp5sfgm0q4ghh3wv33nnjpkavl894zlv7f";
        };
      };
    };
    "symfony/polyfill-ctype" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-ctype-30885182c981ab175d4d034db0f6f469898070ab";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-ctype/zipball/30885182c981ab175d4d034db0f6f469898070ab";
          sha256 = "0dfh24f8g048vbj88vx0lvw48nq5dsamy5kva72ab1h7vw9hvpwb";
        };
      };
    };
    "symfony/polyfill-mbstring" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-mbstring-0abb51d2f102e00a4eefcf46ba7fec406d245825";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/polyfill-mbstring/zipball/0abb51d2f102e00a4eefcf46ba7fec406d245825";
          sha256 = "1z17f7465fn778ak68mzz5kg2ql1n6ghgqh3827n9mcipwbp4k58";
        };
      };
    };
    "symfony/process" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-process-c3591a09c78639822b0b290d44edb69bf9f05dc8";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/process/zipball/c3591a09c78639822b0b290d44edb69bf9f05dc8";
          sha256 = "1xm7v9zzy9ccrq2c87asqzzcp2vrjgi659hxssj3x5qxahpgp0c7";
        };
      };
    };
    "symfony/stopwatch" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-stopwatch-752586c80af8a85aeb74d1ae8202411c68836663";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/stopwatch/zipball/752586c80af8a85aeb74d1ae8202411c68836663";
          sha256 = "1gsrf5388a6vzmdsxlnb4v5a0i01cz4s0da38h9nv7nmwr2f8hdw";
        };
      };
    };
    "symfony/translation" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-translation-eee6c664853fd0576f21ae25725cfffeafe83f26";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/translation/zipball/eee6c664853fd0576f21ae25725cfffeafe83f26";
          sha256 = "1l6nxk7ik8a0hj9lrxgbzwi07xiwm9aai1yd4skswnb0r3qbbxzq";
        };
      };
    };
    "symfony/validator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-validator-d5d2090bba3139d8ddb79959fbf516e87238fe3a";
        src = fetchurl {
          url = "https://api.github.com/repos/symfony/validator/zipball/d5d2090bba3139d8ddb79959fbf516e87238fe3a";
          sha256 = "16y25dj2ag825s0xhx89ajk5di0w4i804p7nw1n10ji6mbswx42w";
        };
      };
    };
    "twig/twig" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "twig-twig-ae39480f010ef88adc7938503c9b02d3baf2f3b3";
        src = fetchurl {
          url = "https://api.github.com/repos/twigphp/Twig/zipball/ae39480f010ef88adc7938503c9b02d3baf2f3b3";
          sha256 = "1bh8c711fb97q6magzhgxfpmzz9xyr10mzx10ch8h60yj8n79n0l";
        };
      };
    };
    "webmozart/assert" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "webmozart-assert-6964c76c7804814a842473e0c8fd15bab0f18e25";
        src = fetchurl {
          url = "https://api.github.com/repos/webmozarts/assert/zipball/6964c76c7804814a842473e0c8fd15bab0f18e25";
          sha256 = "17xqhb2wkwr7cgbl4xdjf7g1vkal17y79rpp6xjpf1xgl5vypc64";
        };
      };
    };
    "zendframework/zend-cache" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-cache-7ff9d6b922ae29dbdc53f6a62b471fb6e58565df";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-cache/zipball/7ff9d6b922ae29dbdc53f6a62b471fb6e58565df";
          sha256 = "1c1fg6kmnxwj1hzwzl8p3n1dk0nxnld3mvya9byly6b9ch15l9xa";
        };
      };
    };
    "zendframework/zend-config" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-config-ec49b1df1bdd9772df09dc2f612fbfc279bf4c27";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-config/zipball/ec49b1df1bdd9772df09dc2f612fbfc279bf4c27";
          sha256 = "0z55igyly3mbp92z50nars7ks3lwzldhvb8wkhrzyf6wr2inp4vj";
        };
      };
    };
    "zendframework/zend-eventmanager" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-eventmanager-b4354f75f694504d32e7d080641854f830acb865";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-eventmanager/zipball/b4354f75f694504d32e7d080641854f830acb865";
          sha256 = "0ls4n2zv09lvgwdqm5xrr2nlb4skl8czh2p7fp4bgmkj5hfasfch";
        };
      };
    };
    "zendframework/zend-filter" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-filter-93e6990a198e6cdd811064083acac4693f4b29ae";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-filter/zipball/93e6990a198e6cdd811064083acac4693f4b29ae";
          sha256 = "1prrr6fcw1mmzx2bs0gb0hwl93xlz7x0irn7zyp2ra659kdsai8f";
        };
      };
    };
    "zendframework/zend-hydrator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-hydrator-f3ed8b833355140350bbed98d8a7b8b66875903f";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-hydrator/zipball/f3ed8b833355140350bbed98d8a7b8b66875903f";
          sha256 = "0xsrv8r84rqasgnf57v9krqm03q4gxg8ld7ly5hbmq75m7v4xxxk";
        };
      };
    };
    "zendframework/zend-i18n" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-i18n-509271eb7947e4aabebfc376104179cffea42696";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-i18n/zipball/509271eb7947e4aabebfc376104179cffea42696";
          sha256 = "0ljl595073i69qs361ifc6i6m9cmbl4l2z0jqz0npw5s47k61l2m";
        };
      };
    };
    "zendframework/zend-json" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-json-e2945611a98e1fefcaaf69969350a0bfa6a8d574";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-json/zipball/e2945611a98e1fefcaaf69969350a0bfa6a8d574";
          sha256 = "031f3nj7qb002xmhqgd8xrzhq11l88x2x54gc4hd249jy89829p5";
        };
      };
    };
    "zendframework/zend-math" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-math-2648ee3cce39aa3876788c837e3b58f198dc8a78";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-math/zipball/2648ee3cce39aa3876788c837e3b58f198dc8a78";
          sha256 = "1jjvlbwjqka62ax0adcfi9jz1p0rhsjc68cwhfn5jg73b1gwh4wp";
        };
      };
    };
    "zendframework/zend-serializer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-serializer-b7208eb17dc4a4fb3a660b85e6c4af035eeed40c";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-serializer/zipball/b7208eb17dc4a4fb3a660b85e6c4af035eeed40c";
          sha256 = "0g85dyd3n74vnhmic2jrj0nalc8sbn42hr0ylf0w0ybk9k1a932s";
        };
      };
    };
    "zendframework/zend-servicemanager" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-servicemanager-1dc33f23bd0a7f4d8ba743b915fae523d356027a";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-servicemanager/zipball/1dc33f23bd0a7f4d8ba743b915fae523d356027a";
          sha256 = "0cz16cj6f5wv6jflz92d6k0cnc54fjal8law68vz6p44rz3dbj46";
        };
      };
    };
    "zendframework/zend-stdlib" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zendframework-zend-stdlib-cae029346a33663b998507f94962eb27de060683";
        src = fetchurl {
          url = "https://api.github.com/repos/zendframework/zend-stdlib/zipball/cae029346a33663b998507f94962eb27de060683";
          sha256 = "1y9wkz2cysq193a925s0xnnzhfjsxjzgwadvj41nwvyy716k6ncx";
        };
      };
    };
    "zetacomponents/base" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zetacomponents-base-2f432f4117a5aa2164d4fb1784f84db91dbdd3b8";
        src = fetchurl {
          url = "https://api.github.com/repos/zetacomponents/Base/zipball/2f432f4117a5aa2164d4fb1784f84db91dbdd3b8";
          sha256 = "00y1zfzkc20237bma25d830xkm2jp78d3i7v1snmj24fc2nps974";
        };
      };
    };
    "zetacomponents/document" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "zetacomponents-document-688abfde573cf3fe0730f82538fbd7aa9fc95bc8";
        src = fetchurl {
          url = "https://api.github.com/repos/zetacomponents/Document/zipball/688abfde573cf3fe0730f82538fbd7aa9fc95bc8";
          sha256 = "15bxwfcd934c41lw1ccmdypn4m1xq0p540x2bfcsc80m6d51nnll";
        };
      };
    };
  };
in
composerEnv.buildPackage {
  inherit packages devPackages noDev;
  name = "svanderburg-php-sbcrud";
  src = ./.;
  executable = false;
  symlinkDependencies = false;
  meta = {
    license = "Apache-2.0";
  };
}
