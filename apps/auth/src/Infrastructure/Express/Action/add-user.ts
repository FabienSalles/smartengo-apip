import { Request } from "express"
import { v4 as uuid } from 'uuid';
import { getConnection } from "typeorm"
import User from "../../../Domain/User/Entity/user"

export async function AddUser(req: Request) {
  const userRepository = await getConnection().getRepository(User);
  const user = new User();
  user.id = uuid();
  user.username = req.body.username;
  user.password = req.body.password;
  user.role = req.body.role;
  await userRepository.save(user);
}


