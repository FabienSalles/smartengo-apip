import "dotenv/config"
import connection from "../TypeORM/connection"
import app from "./app";

connection.create().then(() => {
  const PORT = process.env.PORT

  app.listen(PORT, () => {
    console.log(`server is running on PORT ${PORT}`)
  })
})

