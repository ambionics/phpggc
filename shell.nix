{ pkgs ? import <nixpkgs> { } }:

let
  phpggc = pkgs.callPackage ./package.nix { };
  composer = pkgs.php.packages.composer;
in
pkgs.mkShell {
  packages = [
    phpggc
    pkgs.php
    composer
    pkgs.curl
    pkgs.python3
    pkgs.python3Packages.rich
  ];
}
