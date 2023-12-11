#Python code to read Database Tables 

import mysql.connector
# Connecting to local server 
class AttendanceTracker:
    JDBC_URL = "jdbc:mysql://localhost:3306/attendanceTracker" #Local server
    USERNAME = "root"                                          #Username change for configuration of Mysql
    PASSWORD = "@Coolkid69"                                    # Password 

    def __init__(self):
        self.connection = None

    def connect_to_database(self):
        try:
            self.connection = mysql.connector.connect(
                host="localhost",
                user=self.USERNAME,
                password=self.PASSWORD,
                database="attendanceTracker"
            )
            print("Connected to the database.")
        except mysql.connector.Error as err:
            print(f"Error: {err}")

    def display_table_data(self):
        if self.connection:
            cursor = self.connection.cursor(dictionary=True)
            cursor.execute("SHOW TABLES")
            tables = cursor.fetchall()

            for table in tables:
                table_name_key = next(iter(table))
                table_name = table[table_name_key]
                print(f"\nTable: {table_name}\n{'=' * 30}")

                cursor.execute(f"SELECT * FROM {table_name}")
                rows = cursor.fetchall()

                if rows:
                    for row in rows:
                        print(row)
                else:
                    print("No data in the table.")

            cursor.close()
        else:
            print("Not connected to the database.")

    def close_connection(self):
        if self.connection:
            self.connection.close()
            print("Connection closed.")
        else:
            print("No active connection to close.")


if __name__ == "__main__":
    tracker = AttendanceTracker()
    tracker.connect_to_database()
    tracker.display_table_data()
    tracker.close_connection()
