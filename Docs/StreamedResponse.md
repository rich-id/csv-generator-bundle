# Streamed response

For heavy files, it can be tricky to return the full response in one shot. Enter the streamed response, a way of returning a response by chunks so the client can begin to process the data without waiting for the full content.

The `CsvStreamedResponseFactory` can be used to easily generate CSV chunks and stream it to the response. AS it is an advanced feature, it requires a more precise configuration to use it properly.

