import { RoutesInput } from "./types"
import { AddUser } from "./Action/add-user"

export default ({ app }: RoutesInput) => {

  app.post("/api/user", async (req, res) => {
    const user = await AddUser(req)
    return res.send({ user })
  })

}
