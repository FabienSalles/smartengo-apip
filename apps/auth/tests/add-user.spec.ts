import supertest from "supertest";

import app from "../src/Infrastructure/Express/app";
import connection from '../src/Infrastructure/TypeORM/connection';

beforeAll(async ()=> {
  await connection.create()
});

afterAll(async ()=>{
  await connection.close();
});

beforeEach(async () => {
  await connection.clear();
});

const request = supertest(app)

describe('Create User', () => {
  it('should create a valid user', async done => {
    await request
      .post('api/user')
      .send({
        username: 'john'
      })
      .set('Accept', 'application/json')
      .expect(function(res) {
        console.log(res)
      })
    done()
  })
})

