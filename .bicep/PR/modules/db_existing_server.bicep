
param dbServerName string
param dbName string

resource dbserver 'Microsoft.DBforMySQL/flexibleServers@2023-06-30' existing = {
  name: dbServerName
}

resource database 'Microsoft.DBforMySQL/flexibleServers/databases@2023-06-30' = {
  parent: dbserver
  name: dbName
  properties: {
    charset: 'utf8'
    collation: 'utf8_general_ci'
  }
}
