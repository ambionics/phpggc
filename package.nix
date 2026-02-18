{ lib
, stdenvNoCC
, php
, makeWrapper
}:

stdenvNoCC.mkDerivation rec {
  pname = "phpggc";
  version = "0-unstable";

  src = lib.cleanSource ./.;

  nativeBuildInputs = [
    makeWrapper
  ];

  installPhase = ''
    runHook preInstall

    mkdir -p $out/share/phpggc
    cp -R gadgetchains lib templates phpggc LICENSE README.md Dockerfile test-gc-compatibility.py $out/share/phpggc/
    chmod 0644 $out/share/phpggc/phpggc

    mkdir -p $out/bin
    makeWrapper ${php}/bin/php $out/bin/phpggc \
      --run "cd $out/share/phpggc" \
      --add-flags "-d phar.readonly=0 $out/share/phpggc/phpggc"

    runHook postInstall
  '';

  meta = with lib; {
    description = "PHP Generic Gadget Chains";
    homepage = "https://github.com/ambionics/phpggc";
    license = licenses.asl20;
    platforms = platforms.all;
    mainProgram = "phpggc";
  };
}
