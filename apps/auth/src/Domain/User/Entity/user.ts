import {Entity, Column, PrimaryColumn, CreateDateColumn, UpdateDateColumn} from "typeorm";

@Entity()
export default class User {

    @PrimaryColumn({type:"uuid"})
    id: string | undefined;

    @Column({type: 'varchar'})
    username: string | undefined;

    @Column({type: 'varchar'})
    password: string | undefined;

    @Column({type: 'varchar'})
    role: string | undefined;

    @CreateDateColumn({type: 'timestamp', name: 'created_at' })
    createdAt: Date | undefined;

    @UpdateDateColumn({type: 'timestamp', name: 'updated_at' })
    updatedAt: Date | undefined;
}
