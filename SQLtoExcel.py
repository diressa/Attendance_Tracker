import mysql.connector
import pandas as pd

#Exporting data from Database to Excel 
class AttendanceTracker:
    JDBC_URL = "jdbc:mysql://localhost:3306/attendancetracker"
    USERNAME = "Update for specification"
    PASSWORD = "Update for specification"

    def __init__(self):
        self.connection = None

    def connect_to_database(self):
        try:
            self.connection = mysql.connector.connect(
                host="localhost",
                user=self.USERNAME,
                password=self.PASSWORD,
                database="attendancetracker"
            )
            print("Connected to the database.")
        except mysql.connector.Error as err:
            print(f"Error: {err}")

    def extract_data_to_excel(self):
        if self.connection:
            cursor = self.connection.cursor(dictionary=True)
            cursor.execute("SHOW TABLES")
            tables = cursor.fetchall()

            for table in tables:
                table_name_key = next(iter(table))
                table_name = table[table_name_key]
                print(f"Exporting data from table: {table_name}")

                cursor.execute(f"SELECT * FROM {table_name}")
                rows = cursor.fetchall()

                if rows:
                    df = pd.DataFrame(rows)
                    excel_file_name = f"{table_name}.xlsx"
                    df.to_excel(excel_file_name, index=False)
                    print(f"Data exported to {excel_file_name}")
                else:
                    print(f"No data in the table {table_name}")

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
    tracker.extract_data_to_excel()
    tracker.close_connection()
