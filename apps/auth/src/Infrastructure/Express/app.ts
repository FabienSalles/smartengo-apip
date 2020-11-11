import express, {Application, Request, Response} from "express";
import bodyParser from "body-parser";
import Route from "./route";

const app: Application = express()

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))

app.get("/", (req: Request, res: Response) => {
  res.send("TS App is Running")
})

Route({app});

export default app;
