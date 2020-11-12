# Smartengo App

## Intro

This repository contains at the moment 2 app.

## Installation

You just need to use the Makefile and launch `make up`
Everything should works fine (at least on Ubuntu)
## the API Application

API is based on an API Platform distribution.
I preferred to focus on code quality and design than delivery.
So I didn't use the basic functionalities of APIP, and I didn't finish the app...
For fun and to experience new things, I used : 
* **D**omain **D**riven **D**esign with an Hexagonal architecture
* a **real** CQRS approach by overriding some concepts of APIP
* [Detroit-school](https://github.com/testduble/contributing-tests/wiki/Detroit-school-TDD) TDD ([Classisict](https://martinfowler.com/articles/mocksArentStubs.html#SoShouldIBeAClassicistOrAMockist) testing)

### Check if the app works

Launch `make api/test` and look if everything is green on unit and functional tests

For simplicity, I didn't use the swagger doc. The page should be accessible `https://localhost:8443/docs` but endpoints shouldn't work on it.

### More details of the architecture

#### The tools

I spent a lot of time on the docker part (mostly because I had [permissions issues](https://github.com/api-platform/api-platform/issues/319#issuecomment-307037562) with a [way of installing the APIP distribution](https://github.com/api-platform/api-platform/releases/tag/v2.5.7))
After solving my problems, I installed PHPStan, PHPCsFixer, PHPUnit and some bash alias and makefiles
You can use them in order to see if everything works fine.

### The source architecture

The source code is separated in 3 parts:
1. the `config` folder contains all configuration files link to Symfony and other dependencies.
I used it in particular for APIP ressources, Doctrine mapping and validations.
2. the `src/Domain` folder for all the business logic. This part has no external dependencies (except the Symfony Validator component). 
There are just PHP files which respect some conventions and patterns (SOLID and CQRS principles, Port & Adapter, ...)
3. the `src/Infrastructure` folder that contains all implementations/adapters classes link to the domain and to dependencies. You will find on it some files used to override APIP, all the repositories, Doctrine custom types, Doctrine migrations, Symfony constraints and Symfony Messenger implementations.

There are many more classes than a standard APIP application. This is not really justifiable with such a small business need and small CRUD app without complexities but it could be on the long term.
By focusing on business without the constraints of dependencies we can more easily answer them, speak the same langage, understand each other, build a decoupled sustainable application and thanks to all of that, I was able to get closer to a real TDD practice.

### The testing architecture
This code contains 2 parts :
1. the `Unit` part that help me to build the Domain (use InMemory repositories). 
2. the `Functional` part that help me to build end-to-end endpoints

I tried to change my way of write unit tests. I usually do more functional and integration tests because my way of writing unit test came from a mockist style which generated tests coupled to the implementation with little values and a weak refactoring capacity.
The unit tests of this app are written in a Classisict way. It can be a bit more complicated to understand, but they are more useful, more robust and less coupled to the source code.

### The downside
1. The App and endpoints aren't finish. I just implemented Article and Tag with some validations. There is no security, no users, no reactions and no comments.
2. APIP Platform isn't really fit to CQRS and DDD architecture : listeners are ugly and swagger document does not like when we override APIP resources.

## The Auth Application
Auth is a dockerized Express app.
I created the APP, used Typescript and an ORM (TypeORM) in order to initialize a migration for an user table
I tried to create and test an endpoint with Jest and SuperTest but it didn't works. I didn't look any further.

## The Frontend Application

I didn't do anything on it. I preferred to focus on my main skills (the backend). To be honest I learned Typescript and Angular only  [a few days ago](https://github.com/FabienSalles/angular-tour-of-heroes)...
