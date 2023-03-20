
param dbServerName string
param dbName string

resource dbserver 'Microsoft.DBforMariaDB/servers@2018-06-01' existing = {
  name: dbServerName
}

resource database 'Microsoft.DBforMariaDB/servers/databases@2018-06-01' = {
  parent: dbserver
  name: dbName
  properties: {
    charset: 'utf8'
    collation: 'utf8_general_ci'
  }
}
