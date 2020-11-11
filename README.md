# Smartengo App
## Intro
This repository contains at the moment one app.
## Installation
You just need to use the Makefile and launch `make up`
Everything should works fine (at least on Ubuntu)
## API
API is base on an API Platform distribution.
For fun and to experience new things, I used : 
* **D**omain **D**riven **D**esign with an Hexagonal architecture
* a **real** CQRS approach by overriding some concepts of APIP
* [Detroit-school](https://github.com/testduble/contributing-tests/wiki/Detroit-school-TDD) TDD ([Classisict](https://martinfowler.com/articles/mocksArentStubs.html#SoShouldIBeAClassicistOrAMockist) testing)

### Check if the app works
Launch `make api/test` and look if everything is green on unit and functional tests
<p align="center"><img src="/img/demo.gif?raw=true"/></p>
