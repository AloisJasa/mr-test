# Monorepo tools
Sdílené konfigurace pro P7 projekty.


## Release stages
### Release Candidate
`vendor/bin/monorepo-builder release minor --stage release-candidate`
- vytvoří větev `prepare-release-x.x.x`
- obsahuje:
  - povýšení ...
- nový tag `rc-vx.x.x` 

### After Release Candidate
`vendor/bin/monorepo-builder release minor --stage after-release-candidate`
- commit do masteru/main s povýšením verze dev-master

### Release
`vendor/bin/monorepo-builder release minor --stage release`
po zamergování větve `prepare-release-x.x.x`
- nový tag `vx.x.x` na posledním commitu větve 
