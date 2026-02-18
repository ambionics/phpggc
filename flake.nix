{
  description = "phpggc - PHP Generic Gadget Chains";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";
    flake-utils.url = "github:numtide/flake-utils";
  };

  outputs = { self, nixpkgs, flake-utils }:
    flake-utils.lib.eachDefaultSystem (system:
      let
        pkgs = import nixpkgs { inherit system; };
        phpggc = pkgs.callPackage ./package.nix { };
      in
      {
        packages = {
          default = phpggc;
          phpggc = phpggc;
        };

        apps.default = flake-utils.lib.mkApp { drv = phpggc; };

        devShells.default = import ./shell.nix { inherit pkgs; };
      });
}
